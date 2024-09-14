document.addEventListener('DOMContentLoaded', () => {
    const salon = document.getElementById('salon1');
    const mesas = document.querySelectorAll('.mesa');

    mesas.forEach(mesa => {
        mesa.draggable = true;

        mesa.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', e.target.id);
            setTimeout(() => {
                e.target.classList.add('dragging');
            }, 0);
        });

        mesa.addEventListener('dragend', (e) => {
            e.target.classList.remove('dragging');
            savePositions(); // Llamamos a la función para guardar las posiciones
        });

        salon.addEventListener('dragover', (e) => {
            e.preventDefault();
            const draggingElement = document.querySelector('.dragging');
            if (draggingElement) {
                const salonRect = salon.getBoundingClientRect();
                const x = e.clientX - salonRect.left - draggingElement.offsetWidth / 2;
                const y = e.clientY - salonRect.top - draggingElement.offsetHeight / 2;
                draggingElement.style.left = `${Math.min(Math.max(0, x), salonRect.width - draggingElement.offsetWidth)}px`;
                draggingElement.style.top = `${Math.min(Math.max(0, y), salonRect.height - draggingElement.offsetHeight)}px`;
            }
        });

        mesa.addEventListener('mousedown', () => {
            mesa.classList.add('highlight');
        });

        mesa.addEventListener('mouseup', () => {
            mesa.classList.remove('highlight');
        });
    });

    function savePositions() {
        const positions = [];
        document.querySelectorAll('.mesa').forEach(mesa => {
            const id = mesa.dataset.id;
            const x = parseInt(mesa.style.left);
            const y = parseInt(mesa.style.top);
            positions.push({ id, x, y });
        });

        fetch('/update-positions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ positions })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Posiciones guardadas:', data.message);
        })
        .catch(error => {
            console.error('Error al guardar las posiciones:', error);
        });
        
    }

    
});
