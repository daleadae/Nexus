var fight;
$('#fight-monster').on('click', function() {
    $(this).button('loading');
    $('#monster-progress-hp').css('width', '100%');
    $('#fight-result').css('display', 'none')
    $.getJSON(Routing.generate('nexus_api_fight'), function( data ) {
        if (data.status == "success") {
            fight = new FightManager(data.character, data.monster, data.fight, data.info);
            fight.setupMob();
            fight.launchFight();
        } else {
            $('#fight-result').addClass('alert-'+data.status);
            $('fight-result').html(data.message);
        }
    });
});

function FightManager(player, monster, fight, status) {
    this.player = player;
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
        $('.monster-type').html('Elite');
        $('.monster-hp-current, .monster-hp-total').html('75'); 
    }
    $('.img-monster-avatar').attr('src', TWIG.icon_monster_path.replace('%icon%', this.mob.avatar));            
}

FightManager.prototype.setupPlayer = function() {
    $('.character-level').html(this.player.level);
    $('.character-dps').html(this.getDPS(this.player));
    $('.character-power').html(this.player.power);
    $('.character-attack-speed').html(this.player.attack_speed);            
    $('#character-progress-xp').css('width', this.getPercent(this.player.experience_short, this.player.experience_short_max)+'%');
    $('.character-xp-current').html(this.player.experience_short);
    $('.character-xp-total').html(this.player.experience_short_max);            
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
      var monster_max = $('.monster-hp-total').html();
      $('#monster-progress-hp').css('width', this.getPercent(value.monster, monster_max)+'%');
      $('.character-hp-current').html(value.player);
      var player_max = $('.character-hp-total').html();
      $('#character-progress-hp').css('width', this.getPercent(value.player, player_max)+'%');
      
      this.iterator++;

      this.damageTaken($('#monster-damage'), this.getDPS(this.player));

      if (value.monster > 0) {
        this.damageTaken($('#character-damage'), this.getDPS(this.mob));
      }

      if(typeof this.fight[this.iterator] == 'undefined') {
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
    this.setupPlayer();
    $('.character-fight-number').html(this.player.fight)
    $('#fight-monster').button('reset');
    if (this.player.fight <= 0) {
        $('#fight-monster').hide();
    }

    $("#fight-result").removeClass()
    $("#fight-result").addClass('alert alert-'+this.status.type);
    $("#fight-result").html(this.status.message).fadeIn(1000);
}