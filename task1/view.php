<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Ensures proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automobile statistics</title>
    <!-- Inline CSS for styling error messages -->
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <!-- Main title of the web page -->
    <h1>Automobile statistics tool</h1>
    <!-- The form for filtering the automobile statistics, with method GET -->
    <form method="GET" action="index.php">
        <!-- Fieldset to group the form controls -->
        <fieldset>
            <legend>Filtering options</legend>

            <?php if (isset($error)) { ?>
                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php } ?>

            <select name="manufacturer" id="manufacturer">
                <option value="">Pick a brand</option>
                <!-- PHP loop to populate the manufacturer options -->
                <?php foreach ($manufacturers as $id => $title) { ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></option>
                <?php } ?>
            </select>

            <select name="country" id="country">
                <option value="">Pick a country</option>
                <!-- PHP loop to populate the country options -->
                <?php foreach ($countries as $id => $title) { ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></option>
                <?php } ?>
            </select>

            <label for="year">Production year</label>
            <input type="number" name="year" min="2010" max="2020" />

            <!-- Submit button for the form -->
            <button type="submit">Apply filters</button>
        </fieldset>
    </form>

    <!-- Section to display the query results -->
    <section id="main">
        <!-- PHP conditional to check if there are any results to display -->
        <?php if (count($results) > 0) : ?>
            <table>
                <tr>
                    <th>Manufacturer</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Count</th>
                </tr>
                <!-- PHP loop to render each row of the results -->
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['manufacturer']); ?></td>
                        <td><?= htmlspecialchars($row['model']); ?></td>
                        <td><?= htmlspecialchars($row['color']); ?></td>
                        <td><?= htmlspecialchars($row['count']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <!-- Displayed if there are no results for the selected filters -->
            <p>No results found for the selected filters.</p>
        <?php endif; ?>
    </section>

</body>
</html>
