#!/Python27/python
from math import sqrt
from math import pow
import numpy as np
import random
import collections
"""critics={'A': {'HP1': 4.0, 'SW1': 1.0},
'B': {'HP1': 5.0, 'HP2': 5.0, 
 'HP3': 4.0}, 
'C': {'SW1': 4.0, 'SW2': 5.0},
'D': {'HP2': 3.0, 'SW3': 3.0}}
"""

def pearson_similarity(preferences,u1,u2):
        #get list of users who have common rating
        si = {}
		#get list of all ratings for user1 who have rated common item in user1 and user2
		user1 = {}
		#get list of all ratings for user2 who have rated common item in user1 and user2
		user2 = {}
        for item1 in preferences[u1]:
                for item2 in preferences[u2]:
                        if item1 == item2:
                                si[item1]=1
								user1[item1] = preferences[u1][item1]
								user2[item2] = preferences[u2][item2]
		
		#if both user contains all the ratings as the same value
		compare = lambda x, y: collections.Counter(x) == collections.Counter(y)
		if (compare(user1,user2)) :
			return 1
	
        #print si
        n = len(si);
        #print n
        if n == 0:
                return 0
        sum1 = sum([preferences[u1][it] for it in si])
        sum2 = sum([preferences[u2][it] for it in si])

        sum1sq = sum([pow(preferences[u1][it],2) for it in si])
        sum2sq = sum([pow(preferences[u2][it],2) for it in si])

        psum = sum([preferences[u1][it]*preferences[u2][it] for it in si])
        #print sum1,sum2,sum1sq,sum2sq,psum
        num = n*psum-sum1*sum2
        den = sqrt((n*sum1sq-pow(sum1,2))*(n*sum2sq-pow(sum2,2)))
        if den==0:
                return 0
        else:
                return num/den

def topMatches(preferences,person,n=150,similarity=pearson_similarity):
        scores = [(similarity(preferences,person,other),other)
                        for other in preferences if other != person]
        scores.sort()
        scores.reverse()
        return scores[0:n]

def recommend(preferences,person,similarity=pearson_similarity):
        totals={}
        simSums={}
        matches = topMatches(preferences,person,n=150)
        for x in matches:
                if x[0] <= 0: continue
                for item in preferences[x[1]]:
                        if item not in preferences[person] or preferences[person][item]==0:
                                totals.setdefault(item,0)
                                totals[item] += preferences[x[1]][item]*x[0]
                                simSums.setdefault(item,0)
                                simSums[item] += x[0]

        rankings = [(total/simSums[item],item) for item,total in totals.items()]
        rankings.sort()
        rankings.reverse()
        return rankings[0:10]

def transformpreferences(preferences):
        result={}
        for person in preferences:
                for item in preferences[person]:
                        result.setdefault(item,{})
                        result[item][person] = preferences[person][item]

        return result

#item based filtering
#building the item comparison datset

def calculateSimilarItems(preferences,n=10):
        result={}
        itempreferences = transformpreferences(preferences)
        c=0
        for item in itempreferences:
                c+=1
                if c%100 ==0: print "%d / %d" %(c,len(itempreferences))
                scores = topMatches(itempreferences,item,n=n,similarity=pearson_similarity)
                result[item]=scores
        return result

def recommendation(preferences,itemMatch,user):
        userRating = preferences[user]
        scores={}
        totalSim={}
        for (item,rating) in userRating.items():
                for (similarity,item2) in itemMatch[item]:
                        if item2 in userRating: continue
                        scores.setdefault(item2,0)
                        scores[item2]+=similarity*rating
                        totalSim.setdefault(item2,0)
                        totalSim[item2]+=similarity
        
        rankings = [(score/totalSim[item],item) for item,score in scores.items()]
        rankings.sort()
        rankings.reverse()
        return rankings 

def loadMovielens():
        movies={}
        for line in open("E:\\xampp\\htdocs\\recommend\\data\\u.item", "r"):
                (id,title)=line.split('|')[0:2]
                movies[id]=title
        preferences={}
        for line in open("E:\\xampp\\htdocs\\recommend\\data\\u.base", "r"):
                (user,movieid,rating,ts)=line.split('\t')
                preferences.setdefault(user,{})
                preferences[user][movies[movieid]]=float(rating)
        #print pearson_similarity(preferences,'1','2')
        for line in open("E:\\xampp\\htdocs\\recommend\\inputfile.txt", "r"):
                (movie_id,movie_rating) = line.split('|')
                preferences.setdefault('944',{})
                preferences['944'][movies[str(movie_id)]]=float(movie_rating)
        recommendu = recommend(preferences,'944')
        fo = open("E:\\xampp\\htdocs\\recommend\\recommend.txt","w")
        i=0
        while(i!=8):
                fo.write(str(recommendu[i][1])+ "\n")
                i= i+1
        fo.close()

loadMovielens()
        
""" test={}
        for line in open(path+'/u.test'):
                (uid,mid,rat,tis)=line.split('\t')
                test.setdefault(uid,{})
                test[uid][movies[mid]] = float(rat)
        sum=c=0
        for num in range(1,943):
                p = recommend(preferences,str(num))   
                for omovie in p:
                        if omovie[1] in test[str(num)]:
                                print  omovie[1], omovie[0], test[str(num)][omovie[1]]
                                sum = sum + (omovie[0]-test[str(num)][omovie[1]])**2
                                c=c+1
                                print "\n"
        print float(sum/c)
"""









        






