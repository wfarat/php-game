<?php
$user = $_SESSION['user'];
use App\Context;
Context::getInstance()->buildingController->getBuildings($user->id);
$buildings = $_SESSION['buildings'];
?>
  <!-- ✅ Buildings Section -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-bold">🏠 Buildings</h2>
        <?php foreach ($buildings as $building): ?>
            <div class="mt-2 flex justify-between">
                <span><?= $building->name ?> (Lvl <?= $building->level ?? '0' ?>)</span>
               <?php if($building->isBuildingFinished()): ?> <a href="#"
                   class="text-green-400"
                   onclick="openUpgradePopup(
                        <?= $building->building_id ?>,
                        <?= $building->level ?>,
                        '<?= $building->name ?>',
                        '<?= $building->description ?>',
                        '<?= $building->image ?>',
                        <?= $building->nextLevelCost->resources->wood ?>,
                        <?= $building->nextLevelCost->resources->stone ?>,
                        <?= $building->nextLevelCost->resources->food ?>,
                        <?= $building->nextLevelCost->resources->gold ?>,
                        <?= $building->nextLevelCost->time ?>,
                        <?= $building->nextLevelProduction ?>
                    )">
                    Upgrade
                </a>
               <?php else: ?>
                   <span class="text-red-400 countdown-timer" data-endtime="<?= $building->endsBuildingAt->getTimestamp(); ?>">
    --
</span>
               <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- ✅ Upgrade Popup -->
    <div id="upgradePopup" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-gray-800 p-6 rounded-lg w-96 text-center relative">
            <button onclick="closePopup()" class="absolute top-2 right-2 text-white text-xl">&times;</button>
            <h2 id="popupName" class="text-xl font-bold"></h2>
            <img id="popupImage" class="w-40 mx-auto my-3" src="" alt="">
            <p id="popupDescription" class="text-sm text-gray-400"></p>

            <div class="mt-4">
                <h3 class="font-bold">🔧 Upgrade Cost to Level <span id="popupLevel"></span></h3>
                <p>⏳ Time: <span id="popupTime"></span>s</p>
                <p>🌲 Wood: <span id="popupWood"></span></p>
                <p>⛏ Stone: <span id="popupStone"></span></p>
                <p>🍞 Food: <span id="popupFood"></span></p>
                <p>💰 Gold: <span id="popupGold"></span></p>
            </div>

            <div class="mt-4">
                <h3 class="font-bold">📈 New Production</h3>
                <p>+<span id="popupProduction"></span></p>
            </div>

            <button id="confirmUpgrade" class="bg-green-500 px-4 py-2 rounded-lg mt-4">Confirm Upgrade</button>
        </div>
    </div>

    <script>
        function openUpgradePopup(id, level, name, description, image, wood, stone, food, gold, time, production) {
            document.getElementById('popupName').innerText = name;
            document.getElementById('popupLevel').innerText = level+1;
            document.getElementById('popupDescription').innerText = description;
            document.getElementById('popupImage').src = image;
            document.getElementById('popupTime').innerText = time;
            document.getElementById('popupWood').innerText = wood;
            document.getElementById('popupStone').innerText = stone;
            document.getElementById('popupFood').innerText = food;
            document.getElementById('popupGold').innerText = gold;
            document.getElementById('popupProduction').innerText = production;

            const cost = {
                resources: {
                    wood,
                    stone,
                    food,
                    gold
                },
                time
            }
            document.getElementById('confirmUpgrade').onclick = () => confirmUpgrade(id, level, cost);

            document.getElementById('upgradePopup').classList.remove('hidden');
        }

        function closePopup() {
            document.getElementById('upgradePopup').classList.add('hidden');
        }

        function confirmUpgrade(id, level, cost) {
            fetch('upgrade.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }, // Set JSON headers
                body: JSON.stringify({
                    building_id: id,
                    level,
                    cost              })
            })
                .then(() => {
                    closePopup();
                    location.reload(); // Refresh the page to update the building level
                });
        }
        function startCountdown() {
            const timers = document.querySelectorAll('.countdown-timer');

            timers.forEach(timer => {
                const endTime = parseInt(timer.getAttribute('data-endtime')) * 1000; // Convert to milliseconds

                function updateTimer() {
                    const now = new Date().getTime();
                    const timeLeft = endTime - now;

                    if (timeLeft <= 0) {
                        timer.innerText = "00:00";
                        location.reload();
                        return;
                    }

                    const minutes = Math.floor((timeLeft / 1000 / 60) % 60);
                    const seconds = Math.floor((timeLeft / 1000) % 60);

                    timer.innerText =
                        (minutes < 10 ? "0" : "") + minutes + ":" +
                        (seconds < 10 ? "0" : "") + seconds;
                }

                updateTimer(); // Run immediately
                setInterval(updateTimer, 1000); // Update every second
            });
        }

        document.addEventListener("DOMContentLoaded", startCountdown);
    </script>
