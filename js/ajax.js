(function () {

  var self = this,
      form = document.querySelector('.js-submit');

  self.onSubmitForm = function (e) {

    e.preventDefault();

    var url = this.querySelector('input[name=url]').value,
        element = document.querySelector('.js-response'),
        container = document.querySelector('.js-container');

    if(url.length === 0) {

      console.log('Url is empty :(');
      return;

    }

    self.post((window.location.origin + '/Imgr/rest/rest-api.php'), ('url=' + url), function () {

      element.innerHTML = 'Waiting for response...';

    }, function (data) {

      var json = JSON.parse(data);

      if(json.message) {

        var html = [],
            images = JSON.parse(json.message);

        for(var i = 0; i < images.length; i++) {
          html.push(
            '<img src="' + images[i].src + '"' +
            'width="' + images[i].width + '" ' +
            'height="' + images[i].height + '" '
          );
          if(images[i].alt) html.push('alt="' + images[i].alt + '"');
          html.push('" />');
        }

        container.innerHTML = html.join('');

      }

    });

  };

  self.post = function (url, payload, before, complete) {

    var http = new XMLHttpRequest();

    if(before) {
      before.call();
    }

    http.onreadystatechange = function () {

      if(this.readyState == 4 && this.status == 200) {
        if(complete) complete.call(this, this.responseText);
      }

    };

    http.open('POST', url, true);
    http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    http.send(payload);

  };

  if(!form) {
    return;
  }

  form.addEventListener('submit', self.onSubmitForm);

}());
