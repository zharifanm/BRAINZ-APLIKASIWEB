document.addEventListener('DOMContentLoaded', function() {
    // Format the date input to display in DD/MM/YYYY format
    const deadlineInput = document.getElementById('deadline');
    
    // Set default date to today
    const today = new Date();
    const formattedDate = formatDate(today);
    deadlineInput.value = formattedDate;
    
    // Form validation
    const taskForm = document.getElementById('taskForm');
    
    if (taskForm) {
        taskForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const deadline = document.getElementById('deadline').value;
            
            if (title === '') {
                e.preventDefault();
                alert('Please enter a title for your assignment');
                return false;
            }
            
            if (deadline === '') {
                e.preventDefault();
                alert('Please select a deadline for your assignment');
                return false;
            }
            
            // Check if deadline is in the past
            const deadlineDate = new Date(deadline);
            const currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Reset time part for proper comparison
            
            if (deadlineDate < currentDate) {
                if (!confirm('The deadline you selected is in the past. Do you want to continue?')) {
                    e.preventDefault();
                    return false;
                }
            }
            
            return true;
        });
    }
    
    // Helper function to format date as YYYY-MM-DD for the date input
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        
        return `${year}-${month}-${day}`;
    }
    
    // Add animation for task completion
    const taskCheckboxes = document.querySelectorAll('.task-checkbox');
    taskCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskItem = this.closest('.task-item');
            if (this.checked) {
                taskItem.classList.add('completing');
            } else {
                taskItem.classList.remove('completing');
            }
        });
    });
});