function send_message(message) {
    $.ajax({
      url: '/blogsPro/project/ajax/add_msg.php',
      method: 'post',
      data: {msg: message},
      success: function(data) {
        $('#chatMsg').val('');
        get_messages();
      }
    });
  }
  function send_request(message) {
    $.ajax({
      url: '/blogsPro/project/ajax/send_request.php',
      method: 'post',
      data: {id: message},
      success: function(data) {
      
        get_request();
      }
    });
  }
  function unfollow_req(message) {
    $.ajax({
      url: '/blogsPro/project/ajax/unfollow_user.php',
      method: 'post',
      data: {id: message},
      success: function(data) {
        location.reload();
      }
    });
  }
    /**
   * Get's the follow requests.
   */
  function get_request() {
    $.ajax({
      url: '/blogsPro/project/ajax/get_request.php',
      method: 'GET',
      success: function(data) {
        location.reload();
        $('.follow').html(data);
       
      }
    });
  }
  /**
   * Get's the chat messages.
   */
  function get_messages() {
    $.ajax({
      url: '/blogsPro/project/ajax/get_msg.php',
      method: 'GET',
      success: function(data) {
        $('.msg-wgt-body').html(data);
      }
    });
  }
   /**
   * Get's the notification messages.
   */
  function get_unread_messages() {
    $.ajax({
      url: '/blogsPro/project/ajax/getUnread_msg.php',
      method: 'GET',
      success: function(data) {
        $('.button__badge').html(data);
      }
    });
  }
     /**
   * Get's the notification dropdown messages.
   */
  function get_unreadDrop_messages() {
    $.ajax({
      url: '/blogsPro/project/ajax/getDropdown_msg.php',
      method: 'GET',
      success: function(data) {
        $('.dropdown-content').html(data);
      }
    });
  }
  /**
   * Initializes the chat application
   */
  function boot_chat() {
    var chatArea = $('#chatMsg');
    setInterval(get_messages, 1000);
    chatArea.bind('keydown', function(event) {
   
      if (event.keyCode === 13 && event.shiftKey === false) {
        var message = chatArea.val();
       
        if (message.length !== 0) {
          send_message(message);
          event.preventDefault();
        } else {
          alert('Provide a message to send!');
          chatArea.val('');
        }
      }
    });
  }
  boot_chat();

  function notify() {
    setInterval(get_unread_messages, 1000);
  }
  notify();
  function dropdown() {
    setInterval(get_unreadDrop_messages, 1000);
  }
  dropdown();

  function follow_user() {

    var follow = $('#follow');
        var message = follow.val();
          send_request(message);
          event.preventDefault();
  }
  function unfollow_user() {
  
    var unfollow = $('#follow');
    
        var message = unfollow.val();
       
        unfollow_req(message);
          event.preventDefault();
  }