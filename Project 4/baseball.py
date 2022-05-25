from mimetypes import init
import re
import sys, os

if len(sys.argv) < 2:
    sys.exit(f"Usage: {sys.argv[0]} filename")

file = sys.argv[1]

if not os.path.exists(file):
    sys.exit(f"Error: File '{sys.argv[1]}' not found")

# 
class Player(object):
    # Assign values to each object of class Player
    def __init__(self, name):
        self.name = name

    def battingavg(self):
        # Open the file
        f = open(file, 'r')
        hits_T = 0
        bats_T = 0
        ba = 0
        for line in f:
            # Need to check if X name has been added
            if self.name in line:
                ########
                # Bats
                regex_bats = "[\d]\stimes"
                search1_bats = re.search(regex_bats, line).group()
                search2_bats = re.search("[\d]", search1_bats)
                num_Bats = float(search2_bats.group())
                bats_T += num_Bats
                # Hits
                regex_hits = "[\d]\shits"
                search1_hits = (re.search(regex_hits, line)).group()
                search2_hits = re.search("[\d]", search1_hits)
                num_Hits = float(search2_hits.group())
                hits_T += num_Hits
                ########

        # Calculate each player's batting avg
        ba = hits_T/bats_T
        return "%s: %.3f" %(self.name, ba) # Return a formatted str with name + batting avg

player_name = []
player_avg = []
data = []

with open(file) as infile:        
    lines = (line.rstrip() for line in infile) 
    lines = list(line for line in lines if line and not line.startswith('===') and not line.startswith('#'))
    # Credit to the TA who helped me 1/1 for help coming up with this line above^
    # Truly was not sure how to get rid of those lines, so thank you

# Split the line so that we have the first and last name WITHOUT using .split
# Apend the First and Last Name, to be referenced for print later
for line in lines:
    names = re.findall('\S+', line)
    player_name.append("%s %s" % (names[0], names[1]))
list = set(player_name)

# Define the related variables of the object Class Player, 
# to be associated with / identified by the Player's name
# Append the player's batting average to the main list
for name in list:
    player = Player(name)
    ba = player.battingavg()
    player_avg.append(ba)
    data.append(ba)

# Use the sorted() function to sort the player names alphabetically
sorted_list = (sorted(data))

for allplayers in sorted_list:
    print (allplayers)

# Notes from TA Hours
    # hits
    # at bats
    # Hits / AB

    # re.compile
    # look at re documentation
    # x.match -> match1, match2, match3, match4 
#

# with open('/home/zane/cardinals-1930.txt') as f:

# Take in the first players name, then search
# the entire doc for every stat, adding them up

# If Statement {if name has alr been checked, do not check}

# End loop. Start again for the next player.

# Final Goal is to print all names like this:
# Name : Batting average
# XXX: #.####


##
# Read in each line of file
# for each line, parse to get name and stats
# assign them to a temp variable
# before doing anything else, use the variables that were stored
# to check if a player was in said map, map(player name, player name class)
#
# use a booelan -> first added = true/false
# 
# 
# name to creat a new Player class
# with variables of the class as hits, at bats, runs
#  to store player names
# 