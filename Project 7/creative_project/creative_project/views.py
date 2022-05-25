from django.http import HttpResponse
from django.shortcuts import render, redirect
import requests
from . import functions
from django.contrib.auth.forms import UserCreationForm, AuthenticationForm
from django.contrib.auth.models import User
import json
from django.http import JsonResponse
from django.contrib.auth.decorators import login_required
from django.contrib.auth import login, logout
from . import forms
from .models import Lineup
from .models import Room
from .models import ExtendedUser

# Create your views here.

def register_view(request):
    if request.method == 'POST':
        form = UserCreationForm(request.POST)
        if form.is_valid():
            user = form.save()
            coins = 100
            extendeduser = ExtendedUser.create(ExtendedUser, user, coins)
            extendeduser.save()
            login(request, user)
            return redirect('home')
    else:
        form = UserCreationForm()
    return render(request, 'register.html', {'form':form})

def login_view(request):
    if request.method == 'POST':
        form = AuthenticationForm(data=request.POST)
        if form.is_valid():
            user = form.get_user()
            login(request, user)
            if 'next' in request.POST:
              return redirect(request.POST.get('next'))
            else:
              return redirect('home')    
    else:
        form = AuthenticationForm()
    return render(request, 'login.html', {'form':form})

def logout_view(request):
  if request.method == "POST":
    logout(request)
    return(redirect('http://localhost:8001'))
    
   
@login_required(login_url="/login")
def homepage(request):
  #populate with rooms
  sim_rooms = Room.objects.filter(is_simulated = False)
  rooms = Room.objects.all()
  #rooms = Room.objects.exclude(is_simulated = True)
  print(len(rooms))
  if len(sim_rooms) == 0:
    should_create = "False"
  else:
    should_create = "True"
  return render(request, "homepage.html", {'rooms':rooms, 'should_create': should_create}) #render the rooms too

@login_required(login_url="/login")
def createroom_view(request):
  if request.method == 'POST':
    form = forms.CreateRoom(request.POST)
    if form.is_valid():
      instance = form.save(commit=False)
      instance.creator = request.user
      print(request.user)
      print(instance.creator)
      instance.save()
      return redirect('home')
  else:
    form = forms.CreateRoom()
  return render(request, "createroom.html", {'form': form})

@login_required(login_url="/login")
def room_view(request, slug):
  simulated = False
  if request.method =='POST':
    rooms = Room.objects.filter(slug = slug)
    room = rooms[0]
    room.is_simulated = True
    room.save()
    lineups = Lineup.objects.filter(room__slug=slug)
    for lineup in lineups:
      points = functions.calculate_scores(lineup)
      # lineup.points = points
      print("LINEUP POINTS")
      print(lineup.points)
      # lineup.save()
    simulated = True
    # find lineups in the room, find players in the lineup, calculate
    # scores for each player
    #calculate_lineup_score() handles finding players in a lineup and then calls calculate player scores
  lineups = Lineup.objects.filter(room__slug=slug).order_by('-points')
  if len(lineups) ==0:
    rooms = Room.objects.all()
    message = "There are no lineups in this room yet!"
    # return render(request,'homepage.html',{'message':message, 'rooms':rooms})
    return redirect('home')
  numPlayers = len(lineups)
  if numPlayers > 10:
    if lineups[2].creator == request.user:
      thirdPlace = lineups[2].creator
      extendedusers = ExtendedUser.objects.filter(user = thirdPlace)
      extendeduser = extendedusers[0]
      extendeduser.coins += 50
      if request.method == 'POST':
        extendeduser.save()
      message = "Congratulations, you got third! You have recieved 50 bonus coins."
    if lineups[1].creator == request.user:
      secondPlace = lineups[1].creator
      extendedusers = ExtendedUser.objects.filter(user = secondPlace)
      extendeduser = extendedusers[0]
      extendeduser.coins += 100
      if request.method == 'POST':
        extendeduser.save()
      message = "Congratulations, you got third! You have recieved 100 bonus coins."
  winner = lineups[0]
  if lineups[0].points >0:
    simulated = True
  if simulated:
    if lineups[0].creator == request.user:
      user = lineups[0].creator
      extendedusers = ExtendedUser.objects.filter(user=user)
      extendeduser = extendedusers[0]
      extendeduser.winstreak += 1
      extendeduser.totalWins += 1
      bonus = numPlayers * 50
      extendeduser.coins += bonus
      if request.method == 'POST':
        extendeduser.save()
      bonus = str(bonus)
      message = "Congratulations, you won! You have recieved " + bonus + " coins."
    else:
      extendedusers = ExtendedUser.objects.filter(user = request.user)
      extendeduser = extendedusers[0]
      extendeduser.winstreak = 0
      if request.method == 'POST':
        extendeduser.save()
      message = str(winner.creator) + " won the simulation. Better luck next time"
  else:
    message = ""
  return render(request, 'gameroom.html', {'lineups':lineups, 'slug':slug, 'message':message, 'simulated':simulated})

def deleteroom_view(request):
  slug = request.META.get('HTTP_REFERER')
  print(slug)
  rooms = Room.objects.filter(is_simulated = True)
  for room in rooms:
    if room.slug in slug:
      print("HELLO SLUG?")
      print(room.slug)
      room.delete()
  return redirect('home')

@login_required(login_url="/login")
def buildLineup_view(request):
  if request.method =='POST':
    # print("Coin stuff below")
    data = request.POST.get('data')
    print(data)
    form = forms.CreateLineup(request.POST)
    if form.is_valid():
      instance = form.save(commit=False)
      instance.creator = request.user
      print(request.user)
      print(instance.creator)
      instance.save()
      user = instance.creator
      extendedusers = ExtendedUser.objects.filter(user = user)
      extendeduser = extendedusers[0]
      print(extendeduser.coins)
      print(instance.cost)
      extendeduser.coins -= instance.cost
      extendeduser.save()
      
      return redirect('home')
  else:
    curuser = request.user
    queryset = ExtendedUser.objects.filter(user=curuser)
    extendeduser = queryset.get()
    coins = extendeduser.coins
    form = forms.CreateLineup()
    data = functions.get_batting_stats()
    # print((data))
    # print(data.at[0, 'Name'])
    numRows = data.shape[0]
    players = []
    values = []
    count = []
    for i in range(0,numRows - 1):
      playerName = data.at[i, 'Name']
      value = data.at[i, 'OPS']
      value = functions.ops_to_coins(value)
      # print(playerName)
      players.append(playerName)
      values.append(value)
      count.append(i)
    # data = data.to_json(orient="table")
    # data = json.loads(data)
    relData = zip(players, values, count)
  return render(request, "buildALineup.html", {'relData': relData, 'form':form, 'coins':coins})
  # return render(request, "buildALineup.html", {'relData': relData, 'form':form, 'extendeduser':extendeduser})

def about(request):
   # return HttpResponse('about')
   return render(request, "about.html")

@login_required(login_url="/login")
def leaderboard_view(request):
  users = ExtendedUser.objects.all().order_by('-totalWins')
  curuser = request.user
  curExtended = ExtendedUser.objects.filter(user = curuser)
  curExtended = curExtended[0]
  curuser = curExtended
  return render(request, "leaderboard.html", {'users':users, 'curuser':curuser})



# @login_required(login_url="/login")
# def createLineup_view(request):
#   if request.method == 'POST':
#     form = forms.CreateLineup(request.POST, request.FILES)
#     if form.is_valid:
#       #save article to db
#       return (#location)

#       # idea, maybe a user goes to a page where they can create or join a room
#       # then they go to a room and can build a lineup, which sends them to a build a lineup page with 
#       # the next feature we used for the login: redirect(request.POST.get('next')). Then the return location above will go
#       # back to the room they were in. Handling wins is another story. 
