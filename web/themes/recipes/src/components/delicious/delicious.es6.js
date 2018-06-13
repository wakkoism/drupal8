/**
 * @file
 * A delicious notification alert.
 */

var delicious = (function() {

  /**
   * Public object.
   * @type {{}}
   */
  var self = {};

  /**
   * The delicious recipe content.
   *
   * @type {jQuery}
   */
  var $deliciousContent = jQuery('.delicious-content');

  /**
   * Bind the recipe content click event.
   */
  var bindRecipeContentEvent = () => {
    $deliciousContent.on('click', () => {
      deliciousAlert();
    });
  };

  /**
   * Alert the user that this is delicious.
   */
  var deliciousAlert = () => {
    var notifyMessage = Drupal.t('This is delicious!');
    if ("Notification" in window) {
      if (Notification.permission === 'granted') {
        var notification = new Notification(notifyMessage);
      }
      else {
        // Need to use promise here so it doesn't run before the permission is granted.
        Notification.requestPermission((permission) => {
          if (permission === 'granted') {
            var notification = new Notification(notifyMessage);
          }
        });
      }
    }
  };

  /**
   * Page load event.
   */
  self.onPageLoad = () => {
    bindRecipeContentEvent();
  }

  return self;

})();

jQuery(delicious.onPageLoad);
