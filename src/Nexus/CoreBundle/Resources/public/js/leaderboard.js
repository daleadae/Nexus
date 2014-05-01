var leaderboard;

leaderboard = new LeaderboardManager();

function LeaderboardManager() {
}

LeaderboardManager.prototype.refreshLeaderboard = function() {
    $.getJSON(Routing.generate('nexus_api_leaderboard'), function( data ) {
    	$('#leaderboard').html(data.leaderboard_HTML);
    }).fail(function(jqXHR) {
      window.location.reload(true);
    });
}

setInterval(function () { leaderboard.refreshLeaderboard(); }, 30000);