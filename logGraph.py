import json
import matplotlib.pyplot as plt
from datetime import datetime
import pandas as pd

# File paths for request.json and error.json
request_file_path = './public_html/request.json'
error_file_path = './public_html/error.json'

def parse_log_file(file_path):
    data = []
    try:
        with open(file_path, 'r') as file:
            for line in file:
                try:
                    log_entry = json.loads(line.strip())
                    log_entry['time'] = datetime.strptime(log_entry['time'], '%Y-%m-%d %H:%M:%S')
                    data.append(log_entry)
                except (json.JSONDecodeError, ValueError) as e:
                    print(f"Skipping invalid line in {file_path}: {e}")
    except FileNotFoundError:
        print(f"{file_path} not found.")
    return data

# Parse the data from the log files
request_data = parse_log_file(request_file_path)
error_data = parse_log_file(error_file_path)

# Combine parsed data
all_data = request_data + error_data
df = pd.DataFrame(all_data)

if not df.empty:
    # Convert 'time' to datetime and set as index for resampling
    df['time'] = pd.to_datetime(df['time'])
    df = df.set_index('time')

    # Group data by user, browser, and IP; resample to count occurrences over time
    user_counts = df.groupby('user').resample('T').size().unstack(level=0).fillna(0)
    browser_counts = df.groupby('browser').resample('T').size().unstack(level=0).fillna(0)
    ip_counts = df.groupby('ip').resample('T').size().unstack(level=0).fillna(0)
    page_counts = df.groupby('page').resample('T').size().unstack(level=0).fillna(0)

    # Plot data for each user, browser, and IP with vertical offsets
    plt.figure(figsize=(20, 12))
    offset_step = 0.5  # Step for vertical offset between lines

    # Plot user counts with vertical offsets
    for i, user in enumerate(user_counts.columns):
        plt.plot(user_counts.index, user_counts[user] + i * offset_step, label=f'User: {user}', linestyle='-', marker='.')

    # Plot browser counts with different line styles and vertical offsets
    for i, browser in enumerate(browser_counts.columns):
        plt.plot(browser_counts.index, browser_counts[browser] + i * offset_step, label=f'Browser: {browser}', linestyle='--', marker='.')

    # Plot IP counts with different line styles and vertical offsets
    for i, ip in enumerate(ip_counts.columns):
        ip_label = ip if len(ip) <= 15 else ip[:15] + '...'
        plt.plot(ip_counts.index, ip_counts[ip] + i * offset_step, label=f'IP: {ip_label}', linestyle='-.', marker='.')

    for i, page in enumerate(page_counts.columns):
        plt.plot(page_counts.index, page_counts[page] + i * offset_step, label=f'Page: {page}', linestyle='-.', marker='.')

    plt.xlabel('Time')
    plt.ylabel('Number of Requests')
    plt.title('Timeline of Requests by User, Browser, and IP')
    plt.xticks(rotation=45)
    plt.legend(loc='upper left', bbox_to_anchor=(1, 1))
    plt.tight_layout()
    plt.show()

else:
    print("No data available for plotting.")
