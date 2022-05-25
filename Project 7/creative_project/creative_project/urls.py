
from django.contrib import admin
from django.urls import path, re_path, include
# from django.conf.urls import url, include
from . import views
# from django.contrib.staticfiles.urls import staticfiles_urlpatterns
from django.conf import settings
from django.conf.urls.static import static

urlpatterns = [
    re_path('admin/', admin.site.urls),
#    url(r'^accounts/', include('accounts.urls')),
    re_path(r'^about/$', views.about, name = "about"),
    re_path(r'^$', views.homepage, name = "home"),
    re_path(r'^login/$', views.login_view, name = "login"),
    re_path(r'^register/$', views.register_view, name="register"),
    re_path(r'^logout/$', views.logout_view, name = "logout" ),
    re_path(r'^create-lineup/$', views.buildLineup_view, name = "createLineup"),
    re_path(r'^create-room/$', views.createroom_view, name = "create_room"),
    re_path(r'^delete-room/$', views.deleteroom_view, name="deleteroom"),
    re_path(r'^leaderboard/$', views.leaderboard_view, name= "leaderboard"),
    re_path(r'^(?P<slug>[\w-]+)/$', views.room_view, name= "gameroom"),
]

# urlpatterns += staticfiles_urlpatterns()
urlpatterns += static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)

# creative_project/mylaravel/resources/views/welcome.blade.php