<template>
    <div>
        <div class="row no-margin">
            <div class="col-8">
                <h4>My Expenses</h4>
            </div>
            <div class="col-4 text-right">
                <label>Dashboard</label>
            </div>
        </div>

        <div class="row no-margin py-4">
            <div class="py-4 col-7">
                <table class="table table-sm">
                    <thead align="center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Expense Category</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        
                    </tbody>
                </table>
            </div>

            <div class="py-4 col-5">
                <div class="" align="center">
                    <canvas id="myChart" class="chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>