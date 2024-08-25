<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Category;
use Livewire\WithPagination;

class TaskManager extends Component
{
    use WithPagination;

    public $name;
    public $description;
    public $category_id;
    public $taskId = null;
    public $sortField = 'name'; // Campo padrão para ordenação
    public $sortDirection = 'asc'; // Direção padrão da ordenação
    public $searchName = '';
    public $searchCategory = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
    ];

    public function render()
    {
        $query = Task::with('category');

        if ($this->searchName) {
            $query->where('name', 'like', "%{$this->searchName}%");
        }

        if ($this->searchCategory) {
            $query->where('category_id', $this->searchCategory);
        }

        
        $tasks = $query->orderBy($this->sortField, $this->sortDirection)->paginate(5); 

        return view('livewire.task-manager', [
            'tasks' => $tasks,
            'categories' => Category::all(),
        ]);
    }

    public function storeTask()
    {
        $this->validate();

        try {
            if ($this->taskId) {
                $task = Task::find($this->taskId);
                $task->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'category_id' => $this->category_id,
                ]);
                session()->flash('message', 'Tarefa editada com sucesso.');
            } else {
                Task::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'category_id' => $this->category_id,
                ]);
                session()->flash('message', 'Tarefa criada com sucesso.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro: ' . $e->getMessage());
        }

        $this->resetInputFields();
        $this->applyFilters();
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $this->taskId = $task->id;
        $this->name = $task->name;
        $this->description = $task->description;
        $this->category_id = $task->category_id;
    }


    public function deleteTask($id)
    {
        try {
            $task = Task::find($id);

            if ($task) {
                $task->delete();
                session()->flash('message', 'Tarefa excluída com sucesso.');
                $this->applyFilters(); // Recarrega as tarefas após exclusão
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro: ' . $e->getMessage());
        }
    }



    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->category_id = '';
        $this->taskId = null;
    }

    public function applyFilters()
    {
        $this->render();
    }
}
