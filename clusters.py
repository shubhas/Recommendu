#!/bin/python
import random
import numpy as np
from math import sqrt

def pearson(v1,v2):
	sum1=sum(v1)
	sum2=sum(v2)
	
	sum1sq = sum([pow(v,2) for v in v1])
	sum2sq = sum([pow(v,2) for v in v2])
	
	psum = sum([v1[i]*v2[i] for i in range(len(v1))])
	
	num = psum-(sum1*sum2/len(v1))
	den = sqrt((sum1sq-pow(sum1,2)/len(v1))*(sum2sq-pow(sum2,2)/len(v1)))
	if den==0: return 0
	return 1.0-num/den

def kcluster(utility,n_users,n_items,distance=pearson,k=20):
	#determine minimum and maximum value for each point
	ranges = [(min([utility[i][j] for i in range(n_users)]),max([utility[i][j] for i in range(n_users)])) for j in range(n_items)]
	#print ranges
	#create k randomly placed centroids
	clusters = [[random.random()*(ranges[i][1]-ranges[i][0])+ranges[i][0] for i in range(n_users)] for j in range(k)]
	#print clusters
	lastmatches = None
	for t in range(n_users):
		print 'Iteration %d' %t
		bestmatches=[[] for i in range(k)]
	
		#find which centroid is the closest for each column
		for j in range(n_items):
			col = [utility[i][j] for i in range(n_users)]
			#print len(col)
			bestmatch=0
			for i in range(k):
				d=distance(clusters[i],col)
				if d<distance(clusters[bestmatch],col):bestmatch=i
			bestmatches[bestmatch].append(j)
		print bestmatches
	#if the results are the same as the last time,this is complete
		if bestmatches == lastmatches: break
		lastmatches = bestmatches
	
	#move the centroids to their average members
		for i in range(k):
			avgs = [0.0]*(n_users)
			if len(bestmatches[i])>0:
				for colid in bestmatches[i]:
					for m in range(n_users):
						avgs[m]+=utility[m][colid]
				for j in range(len(avgs)):
					avgs[j] /= len(bestmatches[i])
				clusters[i]=avgs
	return bestmatches


