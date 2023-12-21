var places = ['CHENNAI', 'MUMBAI', 'BENGALURU', 'HYDERABAD', 'KOLKATA', 'COIMBATORE', 'SALEM'];

var fromInput = document.getElementById('from-location');
var toInput = document.getElementById('to-location');

// Autocomplete for "From" location
autocomplete(fromInput, places);

// Autocomplete for "To" location
autocomplete(toInput, places);

function autocomplete(input, arr) {
    var currentFocus;

    input.addEventListener('input', function (e) {
        var val = this.value;

        closeAllLists();

        if (!val) {
            return false;
        }

        currentFocus = -1;

        var list = document.createElement('div');
        list.setAttribute('id', this.id + '-autocomplete-list');
        list.setAttribute('class', 'autocomplete-items');
        this.parentNode.appendChild(list);

        for (var i = 0; i < arr.length; i++) {
            if (arr[i].toUpperCase().includes(val.toUpperCase())) {
                var item = document.createElement('div');
                item.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                item.innerHTML += arr[i].substr(val.length);
                item.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                item.addEventListener('click', function (e) {
                    input.value = this.getElementsByTagName('input')[0].value;
                    closeAllLists();
                });

                list.appendChild(item);
            }
        }

        // Position the autocomplete list below the input field
        var rect = input.getBoundingClientRect();
        list.style.top = (rect.bottom + window.scrollY) + 'px';
        list.style.left = rect.left + 'px';
        list.style.width = input.offsetWidth + 'px';
    });

    input.addEventListener('keydown', function (e) {
        var x = document.getElementById(this.id + '-autocomplete-list');
        if (x) x = x.getElementsByTagName('div');
        if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
        } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
        } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add('autocomplete-active');
    }

    function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove('autocomplete-active');
        }
    }

    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName('autocomplete-items');
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != input) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    document.addEventListener('click', function (e) {
        closeAllLists(e.target);
    });
}
