function getTimeZone(){
  var currentTime = new Date();
  var currentTimezone = currentTime.getTimezoneOffset();
  currentTimezone = (currentTimezone/60) * -1;
  var gmt;
  if (currentTimezone !== 0) {
    gmt = currentTimezone > 0 ? ' +' : ' ';
    gmt = currentTimezone;
  }
  return gmt;
}
