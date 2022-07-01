from mlbgame import day
import mlbgame
from baseball_scraper import batting_stats_range
from pybaseball import batting_stats
from pybaseball import batting_stats_bref

import math
import random

def get_batting_stats():
    return batting_stats(2022)

def get_cur_season_batting():
    return batting_stats_bref()

def ops_to_coins(ops):
    return math.floor((ops * 50 + 10) / 2)

def calculate_scores(lineup):
    player1 = lineup.player1
    player2 = lineup.player2
    player3 = lineup.player3

    data = get_batting_stats()
    # print((data))
    # print(data.at[0, 'Name'])
    numRows = data.shape[0]
    totalHR = 0
    totalR = 0
    totalAB = 0
    totalOBP = 0
    totalHRpct = 0
    totalRpct = 0
    totalKpct = 0
    totalHits = 0
    totalDingers = 0
    totalStrikeouts = 0
    totalRuns = 0
    totalPoints = 0

    # stats we want to look for 
    for i in range(0,numRows - 1):
      playerName = data.at[i, 'Name']
      if((playerName == player1) | (playerName == player2) | (playerName == player3)):
        totalHR += data.at[i,'HR']
        totalAB += data.at[i, 'AB']
        totalOBP += data.at[i, 'OBP']
        totalKpct += data.at[i, "K%"]
        totalR += data.at[i, 'R']
    
    totalOBP = totalOBP / 3.0
    totalHRpct = totalHRpct / totalAB
    totalKpct = totalKpct / 3.0
    totalRpct = totalR / totalAB

    oneHitProb = random.random()/3
    twoHitProb = random.random()/2
    threeHitProb = random.random()
    fourHitProb = random.random() + .2
    print(lineup)
    print("OBP: ", totalOBP)
    print("prob 1 hit: ", oneHitProb)
    print("prob 2 hit: ", twoHitProb)
    print("prob 3 hit: ", threeHitProb)
    print("prob 4 hit: ", fourHitProb)
    if totalOBP >= oneHitProb:
        if totalOBP >= twoHitProb:
            if totalOBP >= threeHitProb:
                if totalOBP >= fourHitProb:
                    print("GOT FOUR HITS")
                    totalPoints+= 20 #four hits
                    totalHits = 4
                else:
                    print("GOT THREE HITS")
                    totalHits += 15 #3 hits
                    totalHits = 3
            else:
                print("GOT TWO HITS")
                totalPoints += 10 #2 hits
                totalHits = 2
        else: 
            print("GOT ONE HIT")
            totalPoints += 5 #1 hit
            totalHits = 1
    else:
        print("GOT NO HITS")
        totalPoints += 0 #0 hits


    oneHRProb = random.random()/3
    twoHRProb = random.random()/2
    threeHRProb = random.random()
    fourHRProb = random.random() + .2

    if totalHRpct >= oneHRProb:
        if totalHRpct >= twoHRProb:
            if totalHRpct >= threeHRProb:
                if totalHRpct >= fourHRProb:
                    print("four dingers")
                    totalPoints+= 60 #four dingers
                    totalDingers = 4
                else:
                    print("Three dingers")
                    totalPoints += 45 #3 hits
                    totalDingers = 3
            else:
                print("Two dingers")
                totalPoints += 30 #2 hits
                totalDingers = 2
        else: 
            print("one dinger")
            totalPoints += 15 #1 hit
            totalDingers = 1
    else:
        print("no dingers :(")
        totalPoints += 0 #0 hits

    oneKProb = random.random()/3
    twoKProb = random.random()/2
    threeKProb = random.random()
    fourKProb = random.random() + .2

    if totalKpct >= oneKProb:
        if totalKpct >= twoKProb:
            if totalKpct >= threeKProb:
                if totalKpct >= fourKProb:
                    print("four Ks")
                    totalPoints-= 30 #four hits
                    totalStrikeouts = 4
                else:
                    print("Three Ks")
                    totalPoints -= 15 #3 hits
                    totalStrikeouts = 3
            else:
                print("Two Ks")
                totalPoints -= 10 #2 hits
                totalStrikeouts = 2
        else: 
            print("one K")
            totalPoints -= 5 #1 hit
            totalStrikeouts = 1
    else:
        print("no Ks")
        totalPoints += 10 #0 hits

    oneRProb = random.random()/3
    twoRProb = random.random()/2
    threeRProb = random.random()
    fourRProb = random.random() + .2

    if totalRpct >= oneRProb:
        if totalRpct >= twoRProb:
            if totalRpct >= threeRProb:
                if totalRpct >= fourRProb:
                    print("four Rs")
                    totalPoints+= 40 #four hits
                    totalRuns = 4
                else:
                    print("Three Rs")
                    totalPoints += 30 #3 hits
                    totalRuns = 3
            else:
                print("Two Rs")
                totalPoints += 20 #2 hits
                totalRuns = 2
        else: 
            print("one R")
            totalPoints += 10 #1 hit
            totalRuns = 1
    else:
        print("no Rs")
        totalPoints += 0 #0 hits
    
    # totalPoints = totalHits + totalDingers + totalRuns + totalStrikeouts
    lineup.hits = totalHits
    lineup.runs = totalRuns
    lineup.strikeouts = totalStrikeouts
    lineup.dingers = totalDingers
    lineup.points = totalPoints
    lineup.save()
    print("TOTAL POINTS EARNED: " , totalPoints)
    return totalPoints



    # scoreboard = mlbgame.data.get_scoreboard(22,4,23)
    # print("scoreboard")
    # print(scoreboard)
    # games = day(2015,4,23)
    # print("games length")
    # print(len(games))
    # # for game in games:
    #     # players = mlbgame.game.players()
    #     # for player in players:
    #     #     #i should also take a look at the player object
    #     #     #if it's more than a name, all i want to compare is player.name
    #     #     if player == lineup.player1 | player == lineup.player2 | player == lineup.player3:
    #     #         #here we have found a player who's playing today in the lineup 
    #     #         # I have to see what a box score looks like to see how we can get the info want from it
    #     #         #but here, i'd imagine I want to search for player and add up their H, HR, K's, BB's, RBI's etc.
    # return 0
    # game.box_score 
    # players = game.players
    # for player in players