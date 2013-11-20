import MySQLdb, string
def eventscornell(location,room_number,day,time,meal,title,free,description):
  db = MySQLdb.connect('cornellfood.db.5837439.hostedresource.com', 'cornellfood', 'CornellFood2@', 'cornellfood');


  # Check if connection was successful
  if (db):
    print "Connection successful"
    print
  else:
    return

  # Creation of a cursor
  cursor = db.cursor()
  table = 'EX!cornellevents'

  # Execution of a parameterized SQL statement
  cursor.execute ("select * from %s" % (table))

  # Get the total number of rows
#new  numrows = int (cursor.rowcount)
#new  print "numrows = ", numrows

  # Get and display the rows one at a time
#new  for i in range (numrows):
#new    row = cursor.fetchone()
#    if (row):
#      print row[0], row[1], row[2], row[3], row[4]


  # Execution of an insert SQL statement


  cursor.execute ("""insert ignore into EX!cornellevents (location,room_number,date,time,meal,title,free,description) 
  values (%s, %s, %s, %s, %s, %s, %s, %s)""", (location,room_number,day,time,meal,title,free,description))




#  cursor.execute ("""insert into cornellevents(location,room_number,date,time,meal,title,free,description) 
#  values (%s, %s, %s, %s, %s, %s, %s, %s)""", (location,room_number,day,time,meal,title,free,description),"""on duplicate key update (location) values(%s)""",(location))


  # Check that the insert operation worked
#  print
#new  print "Check Insert Operation"
  cursor.execute ("select * from cornellevents")
#newnew  numrows = int (cursor.rowcount)
#newnew  print "numrows = ", numrows

  db.close()
 #new  for i in range (numrows):
#new    row = cursor.fetchone()
#    if (row):
#new    db.quit  print'saved to db', row[0], row[1], row[2], row[3],row[4]
