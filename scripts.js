// scripts.js

// To-Do List Functionality
document.addEventListener('DOMContentLoaded', () => {
    const todoInput = document.getElementById('todoInput');
    const todoList = document.getElementById('todoList');

    if (todoInput && todoList) {
        todoInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && todoInput.value.trim() !== '') {
                const listItem = document.createElement('li');
                listItem.textContent = todoInput.value;

                // Add a remove button for each task
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remove';
                removeBtn.style.marginLeft = '10px';
                removeBtn.onclick = () => listItem.remove();

                listItem.appendChild(removeBtn);
                todoList.appendChild(listItem);
                todoInput.value = ''; // Clear input field
            }
        });
    }
});

// Budgeting Table Functionality
document.addEventListener('DOMContentLoaded', () => {
    const budgetTable = document.querySelector('#budgeting table');

    if (budgetTable) {
        const addRowBtn = document.createElement('button');
        addRowBtn.textContent = 'Add Row';
        addRowBtn.style.marginTop = '10px';

        budgetTable.parentElement.appendChild(addRowBtn);

        addRowBtn.addEventListener('click', () => {
            const newRow = budgetTable.insertRow();
            const categoryCell = newRow.insertCell(0);
            const amountCell = newRow.insertCell(1);

            categoryCell.innerHTML = '<input type="text" placeholder="Category">';
            amountCell.innerHTML = '<input type="number" placeholder="Amount">';
        });
    }
});

// Material List Textarea (Save Locally)
document.addEventListener('DOMContentLoaded', () => {
    const materialsTextarea = document.querySelector('#materials textarea');

    if (materialsTextarea) {
        // Load saved data
        const savedMaterials = localStorage.getItem('materials');
        if (savedMaterials) {
            materialsTextarea.value = savedMaterials;
        }

        // Save data on change
        materialsTextarea.addEventListener('input', () => {
            localStorage.setItem('materials', materialsTextarea.value);
        });
    }
});
