import matplotlib.pyplot as plt
import numpy as np
from matplotlib.ticker import MaxNLocator
import matplotlib.colors as mcolors
import matplotlib.cm as cm
from datetime import datetime

#we need to format time
def parseTimeToSeconds(time_str):
    dt = datetime.strptime(time_str, "%Y-%m-%d %H:%M:%S")
    return int(dt.timestamp()) 

#we want to get a json property
def getProperty(property, data):
    if (data.find("page")!=-1):
        result=data[data.find(property)+len(property)+3:]
        result=result[:result.find("\"")]
        return result
    else:
        return "ND"

#This function prints page access over time
def graphOverTimeUsage(name,data):
    x=[]
    y=[]
    for line in data:
        page = getProperty(name, line)
        time_str = getProperty("time", line)
        if time_str != "ND":
            time_seconds = parseTimeToSeconds(time_str)
            x.append(time_seconds)
            y.append(page)
    norm = mcolors.Normalize(vmin=min(x), vmax=max(x))
    cmap = cm.viridis  #choose a color map

    #Create the scatter plot with color gradient
    plt.figure(figsize=(10, 6))
    scatter = plt.scatter(x, y, c=x, cmap=cmap, norm=norm)
    plt.colorbar(scatter, label="Time")  # Add color bar
    plt.xlabel("Time")
    plt.ylabel(name.capitalize())
    plt.title(f"{name.capitalize()} access over time")
    
    #we want to control x-axis tick density
    plt.gca().xaxis.set_major_locator(MaxNLocator(nbins=5))
    
    #save the figure on the server
    plt.savefig(f"{name}_access.png")
    return 0

def browserPie(data):
    title = "Browser Usage Distribution"
    labels = ["Mozilla", "Chrome","Apple", "Edge","Opera", "Else"]
    colors = ["purple", "blue", "lightgreen", "yellow", "orange","red"]
    #start dictionary
    browsers = dict.fromkeys(labels, 0)
    i=0
    for line in data:#here we extract the actual data
        found=False
        for el in browsers:
            if(line.__contains__(el)):
                browsers[el]+=1
                found=True
        if(not found):
            browsers["Else"]+=1
    x = list(browsers.values())

    #we plot pie chart
    plt.figure(figsize=(8, 8))  # Set figure size
    plt.pie(x, labels=labels, colors=colors, autopct='%1.1f%%', startangle=140)
    plt.title(title)
    plt.legend()

    #we save the plot
    plt.savefig("graph.png")  # save the file
    return 0



file=open("./public_html/request.txt")
data=file.readlines()#opening the file
graphOverTimeUsage("page",data)
graphOverTimeUsage("user",data)


