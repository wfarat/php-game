<?php
$user = $_SESSION['user'];

use App\core\Context;

$units = Context::getInstance()->unitController->getUnits($user->id);
$buildings = Context::getInstance()->buildingController->getBuildings($user->id);
$queue = Context::getInstance()->unitController->getQueue($user->id);
?>
<!-- 📌 Middle Panel: Army & Actions -->
<div class="bg-gray-800 p-4 rounded-lg">
    <h2 class="text-lg font-bold">⚔ Army</h2>
    <?php foreach ($units as $unit): ?>
        <div class="mt-2 flex justify-between">
            <span><?= $unit->name ?>: <?= $unit->count ?></span>
            <?php if (array_any($queue, fn($item) => $item->unitId === $unit->unitId)): ?>
                <span class="text-green-400">In Queue</span>
            <?php else: ?>
            <span
                   data-unit-id="<?= $unit->unitId ?>"
                   data-name="<?= $unit->name ?>"
                   data-description="<?= $unit->description ?>"
                   data-image="<?= $unit->image ?>"
                   data-wood="<?= $unit->cost->resources->wood ?>"
                   data-stone="<?= $unit->cost->resources->stone ?>"
                   data-food="<?= $unit->cost->resources->food ?>"
                   data-gold="<?= $unit->cost->resources->gold ?>"
                   data-time="<?= $unit->cost->time ?>"
                   data-production="<?= array_find($buildings, fn($building) => $building->production->kind->value === strtolower($unit->name))->production->amount ?? 0 ?>"
                    class="text-green-400 cursor-pointer hover:underline train-unit"
            >
                Train
            </span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <h2 class="text-lg font-bold mt-4">🌍 Actions</h2>
    <a href="queue.php" class="block text-green-400 mt-2">Units Queue</a>
    <a href="attack.php" class="block text-red-400 mt-2">Attack Enemies</a>
</div>
<div id="unitPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-gray-800 p-6 rounded-lg w-96 text-center relative">
        <button onclick="closeUnitPopup()" class="absolute top-2 right-2 text-white text-xl">&times;</button>
        <h2 id="unitPopupName" class="text-xl font-bold"></h2>
        <img id="unitPopupImage" class="w-40 mx-auto my-3" src="" alt="">
        <p id="unitPopupDescription" class="text-sm text-gray-400"></p>

        <form id="trainUnitsForm">
            <div class="mt-4">
                <label class="block text-white" for="unitQuantity">Number of Units:</label>
                <input
                        type="number"
                        id="unitQuantity"
                        class="w-full bg-gray-700 text-white p-2 rounded-lg"
                        min="1"
                        step="1"
                        value="1"
                        oninput="calculateUnitCost()"
                >
            </div>
            <div class="hidden" >
                <span id="costFood"></span>
                <span id="costWood"></span>
                <span id="costStone"></span>
                <span id="costGold"></span>
                <span id="costTime"></span>
                <span id="unitProduction"></span>
            </div>
            <div class="mt-4">
                <h3 class="font-bold">Estimated Cost:</h3>
                <p>🌲 Wood: <span id="unitWoodCost">0</span></p>
                <p>⛏ Stone: <span id="unitStoneCost">0</span></p>
                <p>🍞 Food: <span id="unitFoodCost">0</span></p>
                <p>💰 Gold: <span id="unitGoldCost">0</span></p>
                <p>💰 Time: <span id="unitTimeCost">0s</span></p>
            </div>

            <div class="mt-4">
                <button type="button" id="confirmTraining" class="bg-green-500 px-4 py-2 rounded-lg">
                    Confirm
                </button>
                <button type="button" onclick="closeUnitPopup()" class="bg-gray-500 px-4 py-2 rounded-lg ml-2">Cancel
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function openUnitPopup(id, name, description, image, production, time, wood, stone, food, gold) {
        document.getElementById('unitPopupName').innerText = `Train ${name}`;
        document.getElementById('unitPopupDescription').innerText = description;
        document.getElementById('unitPopupImage').src = image;
        document.getElementById('unitProduction').innerText = production;
        document.getElementById('costTime').innerText = time;
        document.getElementById('costWood').innerText = wood;
        document.getElementById('costStone').innerText = stone;
        document.getElementById('costFood').innerText = food;
        document.getElementById('costGold').innerText = gold;
        // Set default values
        document.getElementById('unitQuantity').value = 1;
        calculateUnitCost();
        const quantity = parseInt(document.getElementById('unitQuantity').value) || 0;
        const cost = {
            resources: {
                wood: document.getElementById('unitWoodCost').innerText,
                stone: document.getElementById('unitStoneCost').innerText,
                food: document.getElementById('unitFoodCost').innerText,
                gold: document.getElementById('unitGoldCost').innerText
            },
            time: document.getElementById('unitTimeCost').innerText
        }
        document.getElementById('confirmTraining').onclick = () => confirmTraining(id, name, cost, quantity);
        document.getElementById('unitPopup').classList.remove('hidden');
    }

    function closeUnitPopup() {
        document.getElementById('unitPopup').classList.add('hidden');
    }

    function calculateUnitCost() {
        const quantity = parseInt(document.getElementById('unitQuantity').value) || 0;

        // Calculate cost
        const wood = document.getElementById("costWood").innerText * quantity;
        const stone = document.getElementById("costStone").innerText * quantity;
        const food = document.getElementById("costFood").innerText * quantity;
        const gold = document.getElementById("costGold").innerText * quantity;
        const time = document.getElementById("costTime").innerText * quantity / document.getElementById('unitProduction').innerText;

        // Update the UI
        document.getElementById('unitWoodCost').innerText = wood;
        document.getElementById('unitStoneCost').innerText = stone;
        document.getElementById('unitFoodCost').innerText = food;
        document.getElementById('unitGoldCost').innerText = gold;
        document.getElementById('unitTimeCost').innerText = `${time}s`;
    }

    function confirmTraining(id, name, cost, count) {
        if (count < 1) {
            alert('Please enter a valid quantity of units to train.');
            return;
        }
        console.log(cost);
        fetch('train.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }, // Set JSON headers
            body: JSON.stringify({
                unitId: id,
                name,
                cost,
                count})
        })
            .then(() => {
                closeUnitPopup();
                location.reload(); // Refresh the page to update queue
            });

    }

    document.querySelectorAll('.train-unit').forEach(element => {
        element.addEventListener('click', function () {
            const unitId = this.getAttribute('data-unit-id');
            const name = this.getAttribute('data-name');
            const description = this.getAttribute('data-description');
            const image = this.getAttribute('data-image');
            const wood = this.getAttribute('data-wood');
            const stone = this.getAttribute('data-stone');
            const food = this.getAttribute('data-food');
            const gold = this.getAttribute('data-gold');
            const time = this.getAttribute('data-time');
            const production = this.getAttribute('data-production');
            openUnitPopup(unitId, name, description, image, production, time, wood, stone, food, gold);
        })
    })
</script>
