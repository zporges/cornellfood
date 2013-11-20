# -*- coding: utf-8 -*-
# <nbformat>3.0</nbformat>

# <codecell>

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from time import sleep
import time
import datetime
import requests
from xml.dom import *
import xml.etree.cElementTree
import unicodedata
import numpy
import os
from dbwriteevents import eventscornell
import re
from collections import Counter

import xmllib

# <codecell>



#generates a traversibe DOM tree from unicode text of an XML document, must normalize utf-8 into ascii
#
def genTree(utf8Txt):
    src = unicodedata.normalize('NFKD', utf8Txt).encode('ascii','ignore')
    tree = xml.etree.cElementTree.fromstring(src)
    return tree

#separates the events from the localist XML, returning a list of event subtrees
#
def getEvents(tree):
    events = tree.findall('event')
    return events

#gets text, which in this program is XML, from a web page
#
def getTextFromURL(url):
    somePage = requests.get(url)
    return somePage.text
    somePage.close()

#savesPageTxt to a file for later access
#
def savePageTxt(utfTxt,fn):
    
    ts = time.time()
    st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d_%H.%M.%S')
    
    fn = open(fn+st,"w")

    try:
        fn.write(utfTxt.encode('utf8'))
    finally:
        fn.close
    
#locates the 'meta' tag of the returned XML to determine the total number of pages an API call returned
#
def determineNumPages(tree):
    return int(tree.find('meta').find('num_pages').text)

#gets thh Nth page of an API querry
#
def getNthPage(startURL,pageNum):
    return getTextFromURL(startURL+"&page="+str(pageNum))

#gets a week of events from Cornell's localist API which returns XML
#                           
def getWeekOfEvents():
    eventsURL = "http://events.cornell.edu/api/school/10/events?api_key=KLhy2GtuSAGirYGY&days=7&pp=50"
    firstPageTxt = getTextFromURL(eventsURL)
    firstTree = genTree(firstPageTxt)
    allEvents = []
    
    numPages = determineNumPages(firstTree)
    
    curPageNum = 1
    while curPageNum <= numPages:
        curTree = genTree(getNthPage(eventsURL,curPageNum))
        allEvents += getEvents(curTree)
        numPages=determineNumPages(curTree)
        curPageNum+=1
        time.sleep(1)
        
    return allEvents

#gets years worth of food events, was originally used to train a bayesian classifier which failed. Therefore, this function
#isn't really used...but yet I left it in here...maybe it will one day be useful.
#
def getLotsOfFoodEvents():
    foodURL = "http://events.cornell.edu/api/school/10/events?api_key=KLhy2GtuSAGirYGY&days=7&pp=50&start=2010-01-01&end=2013-11-20&type=4259"
    
    firstPageTxt = getTextFromURL(foodURL)
    firstTree = genTree(firstPageTxt)
    allEvents = []
    
    numPages = determineNumPages(firstTree)
    
    foodEvents=[]
    
    curPageNum = 1
    while curPageNum <= numPages:
        foodTxt = getNthPage(foodURL,curPageNum)
        savePageTxt(foodTxt,"FoodTraining"+str(curPageNum))
        curTree = genTree(foodTxt)
        foodEvents += getEvents(curTree)
        numPages=determineNumPages(curTree)
        curPageNum+=1
        time.sleep(1)
    
    return foodEvents

#Gets a week of food events from cornell's API and returns a list of XML trees that represent each event
#
def getWeekOfFoodEvents():
    foodURL = "http://events.cornell.edu/api/school/10/events?api_key=KLhy2GtuSAGirYGY&days=7&pp=50&type=4259"
    
    firstPageTxt = getTextFromURL(foodURL)
    firstTree = genTree(firstPageTxt)
    allEvents = []
    
    numPages = determineNumPages(firstTree)
    
    foodEvents=[]
    
    curPageNum = 1
    while curPageNum <= numPages:
        foodTxt = getNthPage(foodURL,curPageNum)
        curTree = genTree(foodTxt)
        foodEvents += getEvents(curTree)
        numPages=determineNumPages(curTree)
        curPageNum+=1
        time.sleep(1)
    
    return foodEvents

# <codecell>

#gets the relevant info from a single event, and returns it as a dictionary
#
def getRelevantInfo(foodEventInformation):
    info = foodEventInformation
    
    #this is a list of the desired information that we want, these correspond to the columns of a mySQL database
    desired = ['title','start','description','end','free','ticket_price','location','room_number','latitude','longitude']
#    desired = ['title','start','end','free','ticket_price','location','room_number']
 
   
    rel = dict()
    
    #pulls the relevant information from a verbose dictionary of foodEventInformation
    for key in desired:
        try:
            val = info[key]
            rel[key] = val
        except KeyError:
            rel[key] = ""
#            print 'rel',rel['room_number'] 
#            print rel  
    return rel
    
#takes in a list of event trees, iterates over that list, and returns list of dictionaries using getRelevantInfo.
#the dictionaries contain the event information that we found worthwhile for a datebase of food events.
#
def getFoodInfoForDB(foodEvents):
    fes = foodEvents
    fesInfo = []
    
    for fe in fes:
        info = dict()

        for i in fe.iter():
            key = str(i.tag)
            value = str(i.text)
            info[key] = value
        
        fesInfo.append(info)
    
    reducedInfos = []
    
    for event in fesInfo:
        r = getRelevantInfo(event)
        reducedInfos.append(r)


#scrape data parsing and creating table elements
        dname=r['start']
        dname=dname.split("T")
        date=dname[0].split("-")
        s=date[0]+'/'+date[1]+'/'+date[2]
        sec=time.mktime(datetime.datetime.strptime(s,'%Y/%m/%d').timetuple())

        stime=r['start']
        etime=r['end']
        stime=stime.split("T")
        stime=stime[1].split("-")
        stime=stime[0].split(":")

        etime=etime.split("T")
        etime=etime[1].split("-")
        etime=etime[0].split(":")
        start=int(stime[0])
        end=int(etime[0])
       
        if start > 11:
          if start !=12:start=start-12
          setime=str(start)+":"+stime[1]+'pm-'
        else:
         setime=str(start)+":"+stime[1]+'am-'
        if end > 11:
          if end !=12:end=end-12
          setime=setime+str(end)+":"+etime[1]+'pm'
        else:
         setime=setime+str(end)+":"+etime[1]+'am'            
   
        
        s1=int(stime[0])
        if s1 < 10.5:
          meal1='Breakfast'
        elif (s1 > 10.5) and (s1 < 16):
          meal1='Lunch'
#          print 'meal1',stime[0]
        else:
          meal1='Dinner'


        e1=int(etime[0])
        if e1 < 10.5:
          meal2='Breakfast'
        elif (e1 > 10.5) and (e1 < 16):
          meal2='Lunch'
#          print 'meal2',stime[0]
        else:
          meal2='Dinner'
       

#          print'mealq',meal1,meal2
        if meal1==meal2:
          eventscornell(r['location'],r['room_number'],sec,setime,meal1,r['title'],r['free'],r['description'])
        else:
          eventscornell(r['location'],r['room_number'],sec,setime,meal1,r['title'],r['free'],r['description'])
          eventscornell(r['location'],r['room_number'],sec,setime,meal2,r['title'],r['free'],r['description'])
     

    return reducedInfos

# <codecell>

#RAMIN THIS IS THE IMPORTANT DATA
#
#'infos', here below, is a list of python dictionaries that contains relevant event information.
#
# use the function call :  >>> getFoodInfoForDB(getWeekOfFoodEvents()) 
# this call will get the information you require.
# MAKE SURE YOU HAVE ALL THE FUNCTIONS FROM THE TOP OF THIS SCRIPT!! (AND THE IMPORT STATEMENTS)
#
infos = getFoodInfoForDB(getWeekOfFoodEvents())
#print infos
# <codecell>


# <codecell>


