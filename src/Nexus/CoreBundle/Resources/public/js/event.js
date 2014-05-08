function EventManager() {
	this.eventInterval;
}

EventManager.prototype.refreshEventLog = function() {
    $.getJSON(Routing.generate('nexus_api_event_log'), function( data ) {
    	$('#event-log').html(data.eventLog_HTML);
    }).fail(function(jqXHR) {
      window.location.reload(true);
    });
}

EventManager.prototype.launchRefresh = function() {
	this.eventInterval = setInterval(function () { eventLog.refreshEventLog(); }, 30000);
}

EventManager.prototype.stopRefresh = function() {
	clearInterval(this.eventInterval);
}

var eventLog;
eventLog = new EventManager();
eventLog.launchRefresh();
