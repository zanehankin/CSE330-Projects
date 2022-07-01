
# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.contrib import admin
from .models import Room
from .models import Lineup
from .models import Batter
from .models import ExtendedUser

admin.site.register(Room)
admin.site.register(Lineup)
admin.site.register(Batter)
admin.site.register(ExtendedUser)