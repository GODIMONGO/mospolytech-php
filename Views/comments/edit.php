<?php /**
 * Форма редактирования комментария. Получает $comment.
 * После сохранения CommentsController::edit() редиректит на статью.
 */ ?>

<h1>Редактирование комментария</h1>

<form method="post" class="edit-form">
    <label>Текст
        <textarea name="text" rows="6"><?= htmlspecialchars($comment['text']) ?></textarea>
    </label>
    <button type="submit" class="btn">Сохранить</button>
</form>
