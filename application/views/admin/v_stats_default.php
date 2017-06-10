<div id="stats">
	<div id="days">
		<h4>This Week</h4>
		<p>Today  we have <?= $today; ?> new users.</p>
		<p>Yesterday: <?= $yesterday; ?></p>
		<p>This Week: <?= $this_week; ?></p>
		<p>Last Week: <?= $last_week; ?></p>
	</div>

	<div id="month">
		<h4>This month</h4>
		<p>This month we have <?= $this_month; ?></p>
		<p>Last month: <?= $last_month; ?></p>
	</div>

	<div id='year'>
		<h4>This year</h4>
		<p>This year we have <?= $year['yearnum']; ?> new users</p>
	</div>
</div>
