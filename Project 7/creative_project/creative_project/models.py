from csv import unregister_dialect
from django.db import models
from django.contrib.auth.models import User
import datetime

# # Create your models here.
# class Account(models.Model):
#     username = models.CharField(max_length = 20)
#     password = models.TextField()
#     #add in coins
#     #add in any other field

#     def __str__(self):
#         return self.username

class ExtendedUser(models.Model):
    user = models.ForeignKey(User, default=None, on_delete=models.CASCADE)
    coins = models.IntegerField(default=100)
    winstreak = models.IntegerField(default= 0)
    totalWins = models.IntegerField(default=0)
    birthday = models.DateField(default=datetime.datetime.now())

    def create(cls, user, coins):
        extendeduser = cls(user=user,coins=coins)
        return extendeduser
    
    def __str__(self):
        return self.user.username

class Batter(models.Model):
    name = models.CharField(max_length = 100)
    valueOPS = models.DecimalField(
        max_digits=5,
        decimal_places=3
    )
    dingers = models.IntegerField()
    hits = models.IntegerField()

    def __str__(self):
        return self.name


class Room(models.Model):
    roomName = models.CharField(max_length = 50)
    creator = models.ForeignKey(User, default=None, on_delete=models.CASCADE)
    slug = models.SlugField(default="") #so we can make a url
    is_simulated = models.BooleanField(default=False)

    def __str__(self):
        return self.roomName

class Lineup(models.Model):
    name = models.CharField(max_length = 50)
    room = models.ForeignKey(Room, default=None, on_delete=models.CASCADE)
    creator = models.ForeignKey(User, default=None, on_delete=models.CASCADE)
    player1 = models.CharField(max_length= 100)
    player2 = models.CharField(max_length= 100)
    player3 = models.CharField(max_length= 100)
    logo = models.ImageField(default = 'default.png', blank = True)
    points = models.IntegerField(default=0)
    hits = models.IntegerField(default=0)
    dingers = models.IntegerField(default=0)
    strikeouts = models.IntegerField(default = 0)
    runs = models.IntegerField(default=0)
    cost = models.IntegerField(default=0)

    def __str__(self):
        return self.name

