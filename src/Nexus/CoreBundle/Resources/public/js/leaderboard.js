function LeaderboardManager() {
	this.leaderboardInterval;
}

LeaderboardManager.prototype.refreshLeaderboard = function() {
    $.getJSON(Routing.generate('nexus_api_leaderboard'), function( data ) {
    	$('#leaderboard').html(data.leaderboard_HTML);
    }).fail(function(jqXHR) {
      window.location.reload(true);
    });
}

LeaderboardManager.prototype.launchRefresh = function() {
	this.leaderboardInterval = setInterval(function () { leaderboard.refreshLeaderboard(); }, 30000);
}

LeaderboardManager.prototype.stopRefresh = function() {
	clearInterval(this.leaderboardInterval);
}

var leaderboard;
leaderboard = new LeaderboardManager();
leaderboard.launchRefresh();


