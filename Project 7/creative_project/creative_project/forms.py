

from django import forms
from .models import Lineup, Room

class CreateLineup(forms.ModelForm):
    class Meta:
        model = Lineup
        fields = ['player1', 'player2', 'player3', 'name', 'room', 'logo', 'cost']
    
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.fields['room'].queryset = Room.objects.filter(is_simulated = False)
        self.fields['player1'].widget = forms.TextInput(attrs={
            'id': 'player1',
            'placeholder': 'First Player'
        })
        self.fields['player2'].widget = forms.TextInput(attrs={
            'id': 'player2',
            'placeholder': 'Second Player'
        })
        self.fields['player3'].widget = forms.TextInput(attrs={
            'id': 'player3',
            'placeholder': 'Third Player'
        })
        self.fields['cost'].widget = forms.HiddenInput(attrs={
            'id':'cost'
        })


class CreateRoom(forms.ModelForm):
    class Meta:
        model = Room
        fields = ['roomName', 'slug']