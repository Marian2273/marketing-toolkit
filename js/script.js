document.getElementById('like-btn').addEventListener('click', function() {
    const heart = document.getElementById('heart');
    const postId = this.getAttribute('data-postid');
    const userId = this.getAttribute('data-userid');
    
    heart.classList.toggle('liked');

    const liked = heart.classList.contains('liked') ? 1 : 0;

    fetch('like.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ postId, userId, liked })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Like updated successfully');
        } else {
            console.error('Failed to update like');
        }
    })
    .catch(error => console.error('Error:', error));
});
