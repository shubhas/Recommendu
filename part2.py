#!/bin/python
from movielens import *
from math import sqrt
import numpy as np
#from sklearn.metrics import mean_squared_error

# Store data in arrays
user = []
item = []
rating = []
rating_test = []

# Load the movie lens dataset into arrays
d = Dataset()
d.load_users("data/u.user", user)
d.load_items("data/u.item", item)
d.load_ratings("data/u.base", rating)
d.load_ratings("data/u.test", rating_test)
n_users = len(user)
n_items = len(item)

# The utility matrix stores the rating for each user-item pair in the matrix form.
# Note that the movielens data is indexed starting from 1 (instead of 0).
utility = np.zeros((n_users, n_items))
for r in rating:
    utility[r.user_id-1][r.item_id-1] = r.rating

# Finds the average rating for each user and stores it in the user's object
for i in range(n_users):
    rated = np.nonzero(utility[i])
    n = len(rated[0])
    if n != 0:
        user[i].avg_r = np.mean(utility[i][rated])
    else:
        user[i].avg_r = 0.

# Finds the Pearson Correlation Similarity Measure between two users
def pcs(x, y):
	sum1=sum2=sum1sq=sum2sq=psum=0.0
	count=0
	#Traversing  for finding similar items
	for item1 in rating:
		if item1.user_id==x:
			for item2 in rating:
				if item2.user_id==y and item2.item_id==item1.item_id:
					#Add up all the preferences
					sum1 += item1.rating
					sum2 += item2.rating
					#Sum up all the squares
					sum1sq += (item1.rating)**2
					sum2sq += (item2.rating)**2
					#Sum up the products
                                        psum += (item1.rating)*(item2.rating)
					count += 1
	#Calculate Pearson Score
	if count==0: return 0
	numerator = float(psum-(sum1*sum2/count))
	denominator = float(sqrt((sum1sq-pow(sum1,2)/count)*(sum2sq-pow(sum2,2)/count)))
	if denominator == 0: return 0
	
	r = float(numerator/denominator)
	return r

#returns the best matches for person from the class rating.
#Number of results and similarity function are optional parameters.

def topMatches(userid, topn):
	scores=[]
	for x in rating:
		if userid == x.user_id: continue
		print userid,x.user_id
		print pcs(userid,x.user_id)
		scores.append([pcs(userid,x.user_id) , x.user_id])
	scores.sort()
	scores.reverse()
	return scores[0:topn]  

print topMatches(1,150)
# Guesses the ratings that user with id, user_id, might give to item with id, i_id.
# We will consider the top_n similar users to do this.
#def guess(user_id, i_id, top_n):
#	result = topMatches(user_id,top_n)
"""
## THINGS THAT YOU WILL NEED TO DO:
# Perform clustering on users and items
# Predict the ratings of the user-item pairs in rating_test
# Find mean-squared error """
