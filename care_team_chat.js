var live = "http://52.77.117.85/daily_doc/v1/apis/careChatNotification";
//var live = "http://www.portamed.org/v1/apis/careChatNotification";

var Firebase = require('firebase');
var Queue = require('firebase-queue');

Firebase.initializeApp({
  databaseURL: "https://dailydoc-4f24e.firebaseio.com/"
});

var queueRef = Firebase.database().ref('CareTeam/push');
var queue = new Queue(queueRef, function(data, progress, resolve, reject) {
  
  // Read and process task data
  console.log(data);
  var message     = data.message;
  var receiverId  = data.receiverId;
  var chatId   = data.chatId;
  var patientId   = data.patientId;
  var senderId    = data.senderId;
  var chatType    = data.chatType;
  var messageType = data.messageType;
  var senderName = data.senderName;


  // Update the progress state of the task
  setTimeout(function() {
    progress(50);
  }, 500);

  // Call Ajax for processing 
  var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
  var xhttp = new XMLHttpRequest();
  
  var params = "receiverId=" + receiverId + "&message=" + message + "&chatId="+chatId + "&senderId="+senderId + "&chatType="+chatType + "&messageType="+messageType + "&patientId="+patientId + "&senderName="+senderName;

  xhttp.open("POST", live, true);
  xhttp.setRequestHeader("Content-type", "multipart/form-data");
  //xhttp.setRequestHeader("Xapi", "jwZryPtnDm5WFpmDhl2o750G5gVFVSYhpXbg7tlmO");
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
