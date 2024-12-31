const availableList = document.getElementById('availablePages');
const assignedList = document.getElementById('assignedPages');

function dragStart(e) {
    e.dataTransfer.setData('text/plain', e.target.dataset.pageId);
}

function dragOver(e) {
    e.preventDefault();
}

function drop(e) {
    e.preventDefault();
    const pageId = e.dataTransfer.getData('text/plain');
    const pageElement = document.querySelector(`[data-page-id='${pageId}']`);

    if (e.target === availableList || e.target === assignedList) {
        e.target.appendChild(pageElement);
    }
}

availableList.addEventListener('dragstart', dragStart);
assignedList.addEventListener('dragstart', dragStart);

availableList.addEventListener('dragover', dragOver);
assignedList.addEventListener('dragover', dragOver);

availableList.addEventListener('drop', drop);
assignedList.addEventListener('drop', drop);
