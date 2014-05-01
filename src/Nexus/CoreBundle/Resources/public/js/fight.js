var fight;
$('#fight-monster').on('click', function() {
    $(this).button('loading');
    $('#monster-progress-hp').css('width', '100%');
    $('#fight-result').hide().removeClass();
    $.getJSON(Routing.generate('nexus_api_fight'), function( data ) {
        if (data.status == "success") {
            fight = new FightManager(data.character, data.monster, data.fight, data.info);
            fight.setupMob();
            fight.launchFight();
        } else if (data.status == "error") {
            $('#fight-result').addClass('alert alert-danger').html(data.message);
        }
    }).fail(function(jqXHR) {
      window.location.reload(true);
    });
});

function FightManager(character, monster, fight, status) {
    this.character = character;
    this.mob = monster;
    this.fight = fight
    this.iterator = 0;
    this.status = status;
    this.launchFight;
}
  
FightManager.prototype.setupMob = function() {
    $('.monster-name').hide().html(this.mob.name).fadeIn(1500);
    $('.monster-level').html(this.mob.level);
    $('.monster-xp').html(this.mob.experience_reward);
    $('.monster-power').html(this.mob.power);
    $('.monster-attack-speed').html(this.mob.attack_speed);
    $('.monster-dps').html(this.getDPS(this.mob));
    if (this.mob.type == 1) {
        $('.monster-type').html('Normal');
        $('.monster-hp-current, .monster-hp-total').html('50');
    } else if (this.mob.type == 2) {
        $('.monster-type').html('<img src="'+TWIG.icon_elite+'" alt="Elite" title="Elite" class="img-elite img-char-sheet" />Elite');
        $('.monster-hp-current, .monster-hp-total').html('75'); 
    }
    $('.img-monster-avatar').attr('src', TWIG.icon_monster_path.replace('%icon%', this.mob.avatar));            
}

FightManager.prototype.setupPlayer = function() {
    console.log('Update Player');
    $('.character-level').html(this.character.level);
    $('.character-dps').html(this.getDPS(this.character));
    $('.character-power').html(this.character.power);
    $('.character-attack-speed').html(this.character.attack_speed);            
    $('#character-progress-xp').css('width', this.getPercent(this.character.experience_short, this.character.experience_short_max)+'%');
    $('.character-xp-current').html(this.character.experience_short);
    $('.character-xp-total').html(this.character.experience_short_max);            
}

FightManager.prototype.getDPS = function(unit) {
    var dps = unit.power*unit.attack_speed;
    dps = Math.round(dps*100)/100
    return dps;
}

FightManager.prototype.getPercent = function(hp, total) {
    var percentHP = (100*hp)/total;
    return percentHP;
}        

FightManager.prototype.launchFight = function() {
    this.launchFight = setInterval(function() { fight.processFight() }, 1000);
}

FightManager.prototype.processFight = function() {
      var value = this.fight[this.iterator];
      $('.monster-hp-current').html(value.monster);
      $('#monster-progress-hp').css('width', this.getPercent(value.monster, $('.monster-hp-total').html())+'%');
      setTimeout( function() { $('.character-hp-current').html(value.character); }, 500 );
      setTimeout( function() { $('#character-progress-hp').css('width', fight.getPercent(value.character, $('.character-hp-total').html())+'%'); }, 500 );
      
      this.iterator++;

      this.damageTaken($('#monster-damage'), this.getDPS(this.character));

      if (value.monster > 0) {
        setTimeout( function() { fight.damageTaken($('#character-damage'), fight.getDPS(fight.mob)); }, 500);
      }

      if(typeof this.fight[this.iterator] == 'undefined') {
        console.log('fightEnd Process GO');
        window.clearInterval(this.launchFight)
        this.processFightEnd();
      }
}

FightManager.prototype.damageTaken = function(elem, dps) {
      elem.html('-'+dps);
      elem.css('margin-top', $('.img-avatar').height()/2 - $(elem).height()/2);
      elem.css('margin-left', $('.img-avatar').width()/2 - $(elem).width()/2);
      elem.fadeIn(400).fadeOut(400);
}

FightManager.prototype.processFightEnd = function() {
    console.log('Lets update the player');
    this.setupPlayer();
    $('.character-fight-number').html(this.character.fight)
    $('#fight-monster').button('reset');
    if (this.character.fight <= 0) {
        $('#fight-monster').hide();
    }

    $("#fight-result").removeClass().addClass('alert alert-'+this.status.type).html(this.status.message).fadeIn(1000);
}