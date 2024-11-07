import matplotlib.pyplot as plt
import numpy as np

file=open("./public_html/request.txt")
data=file.readlines()#opening the file
title = "Title"
#plt.title(title)
title = "Browser Usage Distribution"
labels = ["Mozilla", "Apple", "Chrome", "Edge", "Else"]
colors = ["purple", "pink", "skyblue", "lightgreen", "orange"]

# Initialize browser count dictionary
browsers = dict.fromkeys(labels, 0)
i=0
for line in data:#here we extract the actual data
    for el in browsers:
        browsers[el]+=line.__contains__(el)
    '''user=line[line.find("user")+len("user")+3:]
    user = user[:user.rfind("\"")]
    y.append(user)
    browser=line[line.find("browser")+len("browser")+3:]
    browser = browser[:browser.rfind("\"")]
    x.append(browser)
    print(user)'''
    
#x=np.linspace(1,len(row)+1, len(row))#create an arguement
#plt.scatter(np.array(x),np.array(y), label=labels[0], color=colors[0])
#we add some detials to the graph
x = list(browsers.values())

# Plot pie chart
plt.figure(figsize=(8, 8))  # Set figure size
plt.pie(x, labels=labels, colors=colors, autopct='%1.1f%%', startangle=140)
plt.title(title)

# Display and save the plot
plt.savefig("graph.png")  # save the file
plt.show()


