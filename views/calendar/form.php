<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name">Titre</label>
            <input id="name" type="text" required class="form-control" name="name" value="<?= isset($data['name']) ? h($data['name']) : ''; ?>">
            <?php if (isset($errors['name'])) : ?>
                <small class="text text-danger"><?= $errors['name']; ?></small>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date">Date</label>
            <input id="date" type="date" class="form-control" name="date" value="<?= isset($data['date']) ? h($data['date']) : ''; ?>">
            <?php if (isset($errors['date'])) : ?>
                <p class="alert alert-danger"><?= $errors['date']; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="start">Démarrage</label>
            <input id="start" type="time" required class="form-control" name="start" placeholder="HH:MM" value="<?= isset($data['start']) ? h($data['start']) : ''; ?>">
            <?php if (isset($errors['start'])) : ?>
                <small class="text text-danger"><?= $errors['start']; ?></small>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="end">Fin</label>
            <input id="end" type="time" required class="form-control" name="end" placeholder="HH:MM" value="<?= isset($data['end']) ? h($data['end']) : ''; ?>">
            <?php if (isset($errors['end'])) : ?>
                <p class="alert alert-danger"><?= $errors['end']; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="description">Descritpion</label>
    <textarea name="description" id="description" class="form-control"> <?= isset($data['description']) ? h($data['description']) : ''; ?></textarea>
</div>