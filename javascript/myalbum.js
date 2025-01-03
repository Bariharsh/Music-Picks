document.addEventListener('DOMContentLoaded', function() {
    const audioElements = {};
    let currentPlaying = null;
    let progressInterval = null;
    let currentAudio = null;
    let currentButton = null;


    // Handle play button click
    document.querySelectorAll('.play-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const songUrl = this.getAttribute('data-song-url');
            const icon = this.querySelector('i');
            const progressBar = this.closest('.card-body').querySelector('.progress-bar');

            // Pause the current playing song if it's not the same as the new song
            if (currentPlaying && currentPlaying !== songUrl) {
                currentAudio.pause();
                currentButton.querySelector('i').classList.replace('bi-pause-circle', 'bi-play-circle');
                clearInterval(progressInterval);
            }

            if (!audioElements[songUrl]) {
                // Create a new audio element if it doesn't exist
                audioElements[songUrl] = new Audio(songUrl);
            }
            const audio = audioElements[songUrl];

            if (icon.classList.contains('bi-play-circle')) {
                icon.classList.remove('bi-play-circle');
                icon.classList.add('bi-pause-circle');
                audio.play();

                // Update progress bar in real time
                progressInterval = setInterval(function() {
                    const percentage = (audio.currentTime / audio.duration) * 100;
                    progressBar.style.width = percentage + '%';
                    progressBar.setAttribute('aria-valuenow', percentage);
                }, 100);

                audio.onended = function() {
                    clearInterval(progressInterval);
                    icon.classList.replace('bi-pause-circle', 'bi-play-circle');
                    progressBar.style.width = '0%';
                    progressBar.setAttribute('aria-valuenow', '0');
                    currentPlaying = null;
                };

                currentPlaying = songUrl;
                currentAudio = audio;
                currentButton = this;

            } else {
                icon.classList.remove('bi-pause-circle');
                icon.classList.add('bi-play-circle');
                audio.pause();
                clearInterval(progressInterval);
            }
        });
    });
    // adding search functionality

    document.getElementById('search-input').addEventListener('input', () => {
        searchSongs();
    });

    function searchSongs() {
        const query = document.getElementById('search-input').value.toLowerCase();
        const songcontainer = document.getElementById('songcontainer');
        const songs = Array.from(songcontainer.getElementsByClassName('display'));

        songs.forEach(song => {
            const title = song.querySelector('h5').textContent.toLowerCase();
            const artist = song.querySelector('p').textContent.toLowerCase();

            if (title.includes(query) || artist.includes(query)) {
                song.style.display = '';
            } else {
                song.style.display = 'none';
            }
        });
    }
});