import matplotlib.pyplot as plt
import numpy as np

file=open("./public_html/request.txt")
data=file.readlines()#opening the file
title = "Title"
#plt.title(title)
title = "Browser Usage Distribution"
labels = ["Mozilla", "Apple", "Chrome", "Edge","Opera", "Else"]
colors = ["purple", "blue", "lightgreen", "yellow", "orange","red"]

# Initialize browser count dictionary
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
    
#x=np.linspace(1,len(row)+1, len(row))#create an arguement
#plt.scatter(np.array(x),np.array(y), label=labels[0], color=colors[0])
#we add some detials to the graph
x = list(browsers.values())

# Plot pie chart
plt.figure(figsize=(8, 8))  # Set figure size
plt.pie(x, labels=labels, colors=colors, autopct='%1.1f%%', startangle=140)
plt.title(title)
plt.legend()

# Display and save the plot
plt.savefig("graph.png")  # save the file
plt.show()


