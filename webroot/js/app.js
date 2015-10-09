// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$(document).ready(function () {
    bindHandlers();
})


/**
 * Sweep the page for bindings indicated by HTML attribute hooks
 * 
 * Class any DOM element with event handlers.
 * Place a 'bind' attribute in the element in need of binding.
 * bind="focus.revealPic blur.hidePic" would bind two methods
 * to the object; the method named revealPic would be the focus handler
 * and hidePic would be the blur handler. All bound handlers
 * receive the event object as an argument
 * 
 * Version 2
 * 
 * @param {string} target a selector to limit the scope of action
 * @returns The specified elements will be bound to handlers
 */
function bindHandlers(target) {
    if (typeof (target) == 'undefined') {
        var targets = $('*[bind*="."]');
    } else {
        var targets = $(target).find('*[bind*="."]')
    }
    targets.each(function () {
        var bindings = $(this).attr('bind').split(' ');
        for (i = 0; i < bindings.length; i++) {
            var handler = bindings[i].split('.');
            if (typeof (window[handler[1]]) === 'function') {
                // handler[0] is the event type
                // handler[1] is the handler name
                $(this).off(handler[0]).on(handler[0], window[handler[1]]);
            }
        }
    });
}

