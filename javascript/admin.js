document.addEventListener('DOMContentLoaded', function() {
    // Handle Edit Button Click
    document.querySelectorAll('.edit-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const songId = this.getAttribute('data-song-id');
            const songName = this.getAttribute('data-song-name');
            const artistName = this.getAttribute('data-artist-name');
            const imageUrl = this.getAttribute('data-image-url');
            const songUrl = this.getAttribute('data-song-url');

            document.getElementById('song_id').value = songId;
            document.getElementById('song_name').value = songName;
            document.getElementById('artist_name').value = artistName;
            document.getElementById('image_url').value = imageUrl;
            document.getElementById('song_url').value = songUrl;
        });
    });
});