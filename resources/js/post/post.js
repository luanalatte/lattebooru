document.getElementById('postImage').addEventListener('click', function() {
    switch (this.dataset.mode) {
        case 'fit':
            this.dataset.mode = 'full';
            break;
        default:
            this.dataset.mode = 'fit';
            break;
    }
});
