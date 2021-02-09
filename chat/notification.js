const firebase = require("firebase-admin");
var serviceAccount = require("../google.json");
firebase.initializeApp({
	credential: firebase.credential.cert(serviceAccount),
	databaseURL: "https://examarly-291907.firebaseio.com"
	//   databaseURL: "https://ivs-admin-d0d01.firebaseio.com"
});
module.exports = {
	sendNotification: async (token, message = 'you have got new msg') => {
		try {
			var deviceToken = token;
			let title = 'Examarly'
			const payload = {
				notification: {
					title: title,
					message: message,
					body: message
				}
			};
			firebase.messaging()
				.sendToDevice(deviceToken, payload)
				.then(res => {
					console.log("successfully push notification on firebase", res);
				})
				.catch((err) => {
					console.log('error to push notification on firebase', err);
				})
		} catch (err) {
			return Promise.reject(err);
		}
	}
}
