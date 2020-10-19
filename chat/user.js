class Users {
    constructor() {
      this.users = [];
    }
  
    addUser(data) {
      var user = data;
      this.users.push(user);
      return user;
    }
  
    removeUser(id) {
      var user = this.getUser(id);
      if (user) {
        this.user = this.users.filter(user => user.id !== id);
      }
      return user;
    }
  
    getUser(id) {
      return this.users.filter(user => user.id === id)[0];
    }
    getUserList(room) {
      var users = users.map(user => user.room === room);
      var namesArray = users.map(user => user.name);
  
      return namesArray;
    }
  }
  
  module.exports = { Users };
  