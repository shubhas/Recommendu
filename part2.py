#!/bin/python
from movielens import *
from math import *
import numpy as np
import clusters as clust
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
utility_old = np.zeros((n_users, n_items))
for r in rating:
    utility_old[r.user_id-1][r.item_id-1] = r.rating

#clustering of similar items i.e movies
k=50
cluster_items = clust.kcluster(utility_old,n_users,n_items,k=50)
utility = np.zeros((n_users, k))
for i in range(n_users):
	for j in range(k):
		sum1=0
		count=0
		q=len(cluster_items[j])
		for p in range(q):
			if utility_old[i][cluster_items[j][p]] != 0.0:
				sum1 += utility_old[i][cluster_items[j][p]]
				count += 1
		if count==0:
			utility[i][j]=0.0
		else:
			utility[i][j] = sum1/float(count)
print utility
				
# Finds the average rating for each user and stores it in the user's object
for i in range(n_users):
    rated = np.nonzero(utility[i])
    n = len(rated[0])
    if n != 0:
        user[i].avg_r = np.mean(utility[i][rated])
    else:
        user[i].avg_r = 0

# Finds the Pearson Correlation Similarity Measure between two users
def pcs(x, y):
    list=[]
    #finding similar items both users had rated
    for item in range(k):
        if utility[x][item] != 0 and utility[y][item] != 0:
            list.append(item)
    if list:
        #Adding up all the preference
        rated_common = len(list)
        sum1 = sum([utility[x][list[i]] for i in range(rated_common)])
        sum2 = sum([utility[y][list[i]] for i in range(rated_common)])  

        #Adding all the sum of the squares
        sum1sq = sum([pow(utility[x][list[i]],2) for i in range(rated_common)])
        sum2sq = sum([pow(utility[y][list[i]],2) for i in range(rated_common)])
    
        #Adding up all sum of the products
        psum = sum([(utility[x][list[i]])*(utility[y][list[i]]) for i in range(rated_common)])

        num = rated_common*psum-sum1*sum2
        den = sqrt((rated_common*sum1sq-pow(sum1,2))*(rated_common*sum2sq-pow(sum2,2)))
    
        """ for i in range(rated_common):
            num += (utility[x][list[i]]-user[x].avg_r)*(utility[y][list[i]]-user[y].avg_r)
            denx += (utility[x][list[i]]-user[x].avg_r)**2
            deny += (utility[y][list[i]]-user[y].avg_r)**2
            den = (denx**0.5) * (deny**0.5) """

        if num==0 and den==0:
            sim=1
        else:
            sim=num/den
    else:
        sim=0
    return sim
    
#returns the best matches for person from the class rating.
#Number of results and similarity function are optional parameters.

def topMatches(userid,itemid,topn):
    scores=[]
    for i in range(n_users):
        if i!=userid:
            sim = pcs(i,userid)
            if sim >=0 and utility[i][itemid]!=0:
                scores.append([sim,i])
    scores.sort()
    scores.reverse()
    return scores[0:topn]  

# Guesses the ratings that user with id, user_id, might give to item with id, i_id.
# We will consider the top_n similar users to do this.

def guess(user_id, i_id, top_n):
    mean=0
    y=user_id-1
    x = i_id-1
    result = topMatches(y,x,top_n)
    m = len(result)
    if m!= 0:
        for i in range(m):
            mean += (utility[result[i][1]][x]-user[result[i][1]].avg_r)
        mean = mean/float(m)
        guess_target = user[y].avg_r + mean
    else:
        guess_target = user[y].avg_r
    return guess_target

n=150
#mylist=[]
# Finds all the missing values of the utility matrix
utility_copy = np.copy(utility)
for i in range(n_users):
        for j in range(k):
            if utility_copy[i][j] == 0:
                utility_copy[i][j] = guess(i+1, j+1, n)

print utility_copy
mylist=[]
for p in range(n_users):
    for k in rating_test:
        for i in range(len(cluster_items)):
            for j in range(len(cluster_items[i])):
                if (k.item_id)-1 == cluster_items[i][j] and (k.user_id)-1 == p:
                        print p+1,cluster_items[i][j]+1
                        print utility_copy[p][i]    #WTF man wrote utility instead of utility_copy and fucked up for one hour...!!!!
                        mylist.append(utility_copy[p][i])

guesses = np.array(mylist)
print guesses
print len(guesses)
mylist=[]
for i in rating_test:
    mylist.append(i.rating)

test = np.array(mylist)
print test
print len(test)
print np.mean(np.power((guesses-test),2))
## THINGS THAT YOU WILL NEED TO DO:
# Perform clustering on users and items
# Predict the ratings of the user-item pairs in rating_test
# Find mean-squared error """
