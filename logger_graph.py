import matplotlib as plt
import numpy as np

file=open("log.txt")
data=file.readlines()#opening the file
title = "Title"
plt.title(title)
labels=["line 1", "line 2"]#labels for graphs and table
colors=["purple", "pink"]
i=0
x=[]
y=[]
for line in data:#here we extract the actual data
    user=line[line.find("user")+len("user")+3:]
    user = user[:user.rfind("\"")]
    x.append(user)
    browser=line[line.find("browser")+len("browser")+3:]
    browser = browser[:browser.rfind("\"")]
    print(user)
    
    #x=np.linspace(1,len(row)+1, len(row))#create an arguement
    #plt.plot(x,np.array(row), label=labels[i], color=colors[i])
#we add some detials to the graph
'''plt.xlabel("something")
plt.ylabel("something")
plt.grid()
plt.legend()
plt.savefig("graph.png")#save the file
file.close()#close the file'''


