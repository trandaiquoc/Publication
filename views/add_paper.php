<link rel="stylesheet" href="public/css/add_paper.css">
<h2>Thêm bài báo mới</h2>
<form id="addPaperForm" method="post" action="index.php?action=addPaper">
    <div class="form-group">
        <label for="title">Tiêu đề:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="abstract">Tóm tắt:</label>
        <textarea id="abstract" name="abstract" required></textarea>
    </div>
    <div class="form-group">
        <label for="conference">Hội nghị:</label>
        <select id="conference" name="conference_id" required>
        </select>
    </div>
    <div class="form-group">
        <label for="topic">Chủ đề:</label>
        <select id="topic" name="topic_id" required>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Tác giả:</label>
        <select id="author" name="author_id[]" multiple required></select>
        <p id="note"><i>*LƯU Ý: Nhấn <b>Ctrl + Click</b> để chọn nhiều thành viên!!</i></p>
    </div>
    <button type="submit">Thêm bài báo</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch conferences
        fetch('index.php?action=getConferences')
            .then(response => response.json())
            .then(data => {
                const conferenceSelect = document.getElementById('conference');
                data.forEach(conference => {
                    const option = document.createElement('option');
                    option.value = conference.conference_id;
                    option.textContent = conference.name;
                    conferenceSelect.appendChild(option);
                });
            });

        // Fetch topics
        fetch('index.php?action=getTopics')
            .then(response => response.json())
            .then(data => {
                const topicSelect = document.getElementById('topic');
                data.forEach(topic => {
                    const option = document.createElement('option');
                    option.value = topic.topic_id;
                    option.textContent = topic.topic_name;
                    topicSelect.appendChild(option);
                });
            });

        // Fetch authors
        fetch('index.php?action=getAuthors')
            .then(response => response.json())
            .then(data => {
                const authorSelect = document.getElementById('author');
                data.forEach(author => {
                    const option = document.createElement('option');
                    option.value = author.user_id;
                    option.textContent = author.full_name;
                    authorSelect.appendChild(option);
                });
            });
    });
</script>