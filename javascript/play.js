document.addEventListener('DOMContentLoaded', function() {
    const audioElements = {};
    let currentPlaying = null;
    let currentAudio = null;
    let currentButton = null;
    // let currentProgressBar = null;
    let progressBarInterval = null;

    // Handle star button click
    document.querySelectorAll('.star-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const songId = this.getAttribute('data-song-id');
            const icon = this.querySelector('i');

            // AJAX request to star/unstar the song
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'star_song.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (icon.classList.contains('bi-star')) {
                        icon.classList.remove('bi-star');
                        icon.classList.add('bi-star-fill');
                        icon.classList.add('starred');
                        // const alertmessage = document.getElementById('alert-message');
                        // alertmessage.style.display = 'block';
                        // alertmessage.classList.add('show'); 
                        alert("Your Song Has Been Saved.")
                    } else {
                        icon.classList.remove('bi-star-fill');
                        icon.classList.add('bi-star');
                        icon.classList.remove('starred');
                    }
                }
            };
            xhr.send('song_id=' + songId);
        });
    });

    // Handle play button click
    document.querySelectorAll('.play-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const songUrl = this.getAttribute('data-song-url');
            const icon = this.querySelector('i');
            const progressBar = this.closest('.card-body').querySelector('.progress-bar');
            const progress = this.closest('.card-body').querySelector('.progress');

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
                
                // Add click event listener to the progress bar
                progress.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const clickedPosition = x / this.offsetWidth;
                    const newTime = clickedPosition * audio.duration;
                    audio.currentTime = newTime;
                });
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


            if (title.includes(query)) {
                song.style.display = 'block';
            } else {
                song.style.display = 'none';
            }
        });
    }

});