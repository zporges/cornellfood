# -*- coding: utf-8 -*-
# <nbformat>3.0</nbformat>

# <codecell>

from bs4 import BeautifulSoup as bs
from bs4 import Comment
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from time import sleep
import time
import datetime
import os

import MySQLdb, string


#connect to db
db = MySQLdb.connect('cornellfood.db.5837439.hostedresource.com', 'cornellfood', 'CornellFood2@', 'cornellfood');
db.autocommit(True)
  # Check if connection was successful
if (db):
    print "Connection successful"



def getMenu(dr,tag):
    men = (dr.find_element_by_class_name("xza")).text
    print men
    print "\n\n"
    return men
	
    
def saveMenu(dir,men):
	newMenu = open((outputDir + "/"+ dir + ".txt"), 'w')
	newMenu.write(men)
	newMenu.close()
    
def getDates(d):
	dates = d.find_element_by_name("navList1")
	return dates

def getMeals(d):
	meals = d.find_element_by_name("navList2")
	return meals

def getPlaces(d):
	places = d.find_element_by_name("navList3")
	return places

def getOptions(s):
	options = s.find_elements_by_tag_name("option")
	return options

# <codecell>

#The next comment contains the xpath to text
#/html/body/div/form/div/div[3]/div/div[6]/div/table/tbody/tr/td/table/tbody/tr[12]/td[2]/div/div[2]/div/div[2]/table/tbody
#//*[@id="t2::db"]/table


ts = time.time()

st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H.%M.%S')

outputDir = "menu_output_"+st

os.mkdir(outputDir)

global sleepInt 
sleepInt = 1
print "The sleep interval is " + str(sleepInt) +" seconds" + "\n\n"


path1= "/html/body/div/form/div/div[3]/div/div[6]/div/table/tbody/tr/td/table/tbody/tr[12]/td[2]/div/div[2]/div/div[2]/table/tbody"
path2 = '//*[@id="t2::db"]/table'
classname="xza x102"
classname2= "xzy"

locater = classname2

#URL that's being scraped
cd = "http://melian3.campuslife.cornell.edu:7790/dining_menus/faces/menu_start.jspx"

#opens Firefox as the web Javascript driver
driver = webdriver.Firefox() #dr is the driver
driver.implicitly_wait(60) # the driver now waits up to this number of seconds for dynamic html to load.

#tells the driver to open the URL
driver.get(cd)

dc = 0

# <codecell>

print (driver.find_element_by_class_name("xza")).text

# <codecell>

sleepInt= 0.5

dates = getOptions(getDates(driver))
d=1
while d < len(dates):
    dname= dates[d].text
    dates[d].click()
    time.sleep(sleepInt)
    
    meals = getOptions(getMeals(driver))
    m=0
    while m < len(meals):
        mname = meals[m].text
        meals[m].click()
        time.sleep(sleepInt)
        
        places = getOptions(getPlaces(driver))
        p=0
        while p < len(places):
            pname = places[p].text
            places[p].click()
            time.sleep(sleepInt)
            
            fn = dname + "++"+ mname + "++" + pname
            print fn
            
            sm = getMenu(driver,locater)
            saveMenu(fn,sm)

#scraped file parsing and creating table elemente 
            tt=open('dining.txt','w')
            tt.write(sm)
            tt.close()

            data=[]
            infile = open ("./dining.txt", "r")
            for line in infile:
               line = line.rstrip("\n")
               line = line.strip()
               seq = line.split("  ")
               seq = tuple (seq)
               data.append(seq)


               date=dname
               date=date.rstrip("\n")
               date=date.strip()
               date=date.split(",")
               date=tuple(date)
               new=date[1].split(" ")
               new=tuple(new)
               s=new[1]+'/'+new[2]+'/'+date[2]

               secend=time.mktime(datetime.datetime.strptime(s,'%B/%d/ %Y').timetuple())

               date=secend
               meal=mname
               location=pname
               station=seq[0]
               menu=seq[1]
               if meal=='Brunch': meal='Breakfast'
#write ro db
               cursor = db.cursor()
               table = 'test'
  # Execution of a parameterized SQL statement
               cursor.execute ("select * from %s" % (table))
               cursor.execute ("""insert into test (date, meal, location, menu) 
                values (%s, %s, %s, %s)""", (date, meal, location, menu))



            
            places=getOptions(getPlaces(driver))
            p+=1
            
        meals= getOptions(getMeals(driver))
        m+=1

    dates = getOptions(getDates(driver))
    d+=1

# <codecell>

driver.close()

