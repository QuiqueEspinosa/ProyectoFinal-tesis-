// scripts.js

document.addEventListener('DOMContentLoaded', function() {
    const leftList = document.getElementById('leftList');
    const rightList = document.getElementById('rightList');

    // Initialize sortable for left list
    new Sortable(leftList, {
        group: 'shared',
        animation: 150,
        chosenClass:"seleccionado",
        // ghostClass:"fantasma"
        dragClass:"drag",
        onEnd: function(evt) {
            updatePositions();
        }
    });

    // Initialize sortable for right list
    new Sortable(rightList, {
        group: 'shared',
        animation: 150,
        chosenClass:"seleccionado",
        // ghostClass:"fantasma"
        dragClass:"drag",
        onEnd: function(evt) {
            updatePositions();
        }
    });

    function updatePositions() {
        const leftItems = Array.from(leftList.children).map((item, index) => ({
            id: item.getAttribute('data-id'),
            posicion: index + 1,
            lista: 'izquierda'
        }));

        const rightItems = Array.from(rightList.children).map((item, index) => ({
            id: item.getAttribute('data-id'),
            posicion: index + 1,
            lista: 'derecha'
        }));

        const positions = [...leftItems, ...rightItems];

        fetch('/update-positions', {  // Cambia la URL si es necesario
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ positions })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                console.log(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
