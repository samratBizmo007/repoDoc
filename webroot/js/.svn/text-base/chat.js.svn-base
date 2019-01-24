var Queue = require('firebase-queue'), Firebase = require('firebase');
var queueRef = new Firebase('https://dailydoc-4f24e.firebaseio.com/push');
var queue = new Queue(queueRef, function(data, progress, resolve, reject) {

  // Read and process task data
  //console.log(data);
  
  //console.log("======");
  var message     = data.message;
  var receiverId  = data.receiverId;
  var chatId   = data.chatId;
  var senderId    = data.senderId;


  if(data.imageURL) {
    imageURL    = data.imageURL;
  }
  if(data.lat) {
    lat    = data.lat;
  }
  if(data.lng) {
    lng    = data.lng;
  }
  

  // Update the progress state of the task
  setTimeout(function() {
    progress(50);
  }, 500);

  // Call Ajax for processing 
  var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
  var xhttp = new XMLHttpRequest();
  
  var params = "receiverId=" + receiverId + "&message=" + message + "&messageId="+messageId + "&senderId="+senderId
   + "&imageURL="+imageURL + "&lat=" + lat + "&lng="+lng + "&timeStamp="+timeStamp;

  var params = "receiverId=" + receiverId + "&message=" + message + "&chatId="+chatId + "&senderId="+senderId;
  xhttp.open("POST", "http://52.77.117.85/daily_doc/v1/apis/chatNotification", true);
  xhttp.setRequestHeader("Content-type", "multipart/form-data");
  //xhttp.setRequestHeader("Xapi", "1QiFE2ywtnDl4rdXzQ_9OkgLJJFXrCQxAHLS3Sg7LSGk");
  xhttp.send(params);

  // get response
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      console.log(xhttp.responseText);
    }
  };

  // Finish the job asynchronously
  setTimeout(function() {
    resolve();
  }, 1000);

});
