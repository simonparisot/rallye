/*
* using cross platform MIDI library MIDI.js http://www.midijs.net/
*/

/*
var midifiles = {
	"title" : "midi/title.mid",
	"map" : "midi/map.mid",
	"background" : "midi/background.mid",
	"overground" : "midi/overground.mid",
	"underground" : "midi/underground.mid",
	"castle" : "midi/castle.mid",
};

Mario.PlayMusic = function(name) {
	if(name in midifiles)
	{
		// Currently we stop all playing tracks when playing a new one
		// MIDIjs can't play multiple at one time
		MIDIjs.stop();;
		MIDIjs.play(midifiles[name]);
	}else{
		console.error("Cannot play music track " + name + " as i have no data for it.");
	}
};*/

Mario.PlayTitleMusic = function() {
	//Mario.PlayMusic("title");
	Enjine.Resources.PlaySound("theme", 1);
};

Mario.PlayMapMusic = function() {
	//Mario.PlayMusic("map");
};

Mario.PlayOvergroundMusic = function() {
	//Mario.PlayMusic("background");
	Enjine.Resources.PlaySound("theme");
};

Mario.PlayUndergroundMusic = function() {
	//Mario.PlayMusic("underground");
	Enjine.Resources.PlaySound("theme");
};

Mario.PlayCastleMusic = function() {
	//Mario.PlayMusic("castle");
	Enjine.Resources.PlaySound("theme");
};

Mario.StopMusic = function() {
	//MIDIjs.stop();
};
