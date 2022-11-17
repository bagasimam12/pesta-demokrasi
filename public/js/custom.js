(function(){
    if (!window.jQuery) {
        throw Error("jQuery needed, but not loaded?");
    }

    // usage
    // $("#selector").inputFilter(function(value) {
    //     return /^\d*$/.test(value); 
    // });

    window.jQuery.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          } else {
            this.value = "";
          }
        });
    };
})();

function swalError(title, text, callback = undefined) {
  Swal.fire({
    icon: 'error',
    title: title,
    text: text
  }).then((r) => {
    if (typeof callback === 'function') {
      return callback(r);
    }
  });
}

function swalSuccess(title, text, callback = undefined) {
  Swal.fire({
    icon: 'success',
    title: title,
    text: text
  }).then((r) => {
    if (typeof callback === 'function') {
      return callback(r);
    }
  });
}

function swalWarning(title, text, callback = undefined) {
  Swal.fire({
    icon: 'warning',
    title: title,
    text: text
  }).then((r) => {
    if (typeof callback === 'function') {
      return callback(r);
    }
  });
}