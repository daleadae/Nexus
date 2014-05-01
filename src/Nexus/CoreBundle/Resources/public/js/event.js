var eventLog;

eventLog = new EventManager();

function EventManager() {
}

EventManager.prototype.refreshEventLog = function() {
    $.getJSON(Routing.generate('nexus_api_event_log'), function( data ) {
    	$('#event-log').html(data.eventLog_HTML);
    }).fail(function(jqXHR) {
      window.location.reload(true);
    });
}

setInterval(function () { eventLog.refreshEventLog(); }, 30000);