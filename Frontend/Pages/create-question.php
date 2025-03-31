<!-- Add these fields to your question creation form -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
        <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            <option value="">Select Category</option>
            <option value="data_structures">Data Structures</option>
            <option value="algorithms">Algorithms</option>
            <option value="programming">Programming</option>
            <option value="database">Database</option>
            <option value="system_design">System Design</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Difficulty Level</label>
        <select name="difficulty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </div>
</div> 