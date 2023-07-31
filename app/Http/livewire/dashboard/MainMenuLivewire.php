<?php
 
namespace App\Http\Livewire\dashboard;
 
use Livewire\Component;
use App\Models\Mainmenu;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
 
class MainMenuLivewire extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
 
    // public $name, $email, $role, $student_id, $status;
    public $search = '';
    public $glang;
 
    public function mount()
    {
        $this->glang = app('glang');
    }

    // protected function rules()
    // {
    //     return [
    //         'name_en' => 'required|string|min:6',
    //         'name_en' => 'required|string|min:6',
    //         'name_en' => 'required|string|min:6',
    //         'email' => ['required','email'],
    //         'role' => 'required',
    //     ];
    // }
 
    // public function updated($fields)
    // {
    //     $this->validateOnly($fields);
    // }
 
    // public function saveStudent()
    // {
    //     $validatedData = $this->validate();
    //     $validatedData['status'] = 1; // Set the default status value here
 
    //     User::create($validatedData);
    //     session()->flash('message','Student Added Successfully');
    //     $this->resetInput();
    //     $this->dispatchBrowserEvent('close-modal');
    // }
     
    // public function editStudent(int $student_id)
    // {
    //     $student = User::find($student_id);
    //     if($student){
 
    //         $this->student_id = $student->id;
    //         $this->name = $student->name;
    //         $this->email = $student->email;
    //         $this->role = $student->role;
    //     }else{
    //         return redirect()->to('/rest');
    //     }
    // }
 
    // public function updateStudent()
    // {
    //     $validatedData = $this->validate();
 
    //     User::where('id',$this->student_id)->update([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'role' => $validatedData['role']
    //     ]);
    //     session()->flash('message','Student Updated Successfully');
    //     $this->resetInput();
    //     $this->dispatchBrowserEvent('close-modal');
    // }

    public function updateStatus(int $menu_id)
    {
        $menuState = Mainmenu::find($menu_id);

        // Toggle the status (0 to 1 and 1 to 0)
        $menuState->status = $menuState->status == 0 ? 1 : 0;
    
        $menuState->save();
        session()->flash('message', 'User Status Updated Successfully');
    }
     
    // public function deleteStudent(int $student_id)
    // {
    //     $this->student_id = $student_id;
    // }
 
    // public function destroyStudent()
    // {
    //     User::find($this->student_id)->delete();
    //     session()->flash('message','Student Deleted Successfully');
    //     $this->dispatchBrowserEvent('close-modal');
    // }
 
    // public function closeModal()
    // {
    //     $this->resetInput();
    // }
 
    // public function resetInput()
    // {
    //     $this->name = '';
    //     $this->email = '';
    //     $this->role = '';
    // }
 
    public function render()
    {
        $colspan = 6;
        $cols_th = ['#','USER ID','Name','status','actions'];
        $cols_td = ['id','user_id','translation.name','status','actions'];

        $data = Mainmenu::with(['translation' => function ($query) {
            $query->where('lang', $this->glang);
        }])
        ->where('user_id', Auth::id())
        ->whereHas('translation', function ($query) {
            $query->where('lang', $this->glang)
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('user_id', 'like', '%' . $this->search . '%');
                });
        })
        ->orderBy('id', 'DESC')
        ->paginate(3);
        //$students = Student::select('id','name','email','course')->get();
        return view('dashboard.livewire.user-table2', ['items' => $data, 'cols_th' => $cols_th, 'cols_td' => $cols_td,'colspan' => $colspan]);
    }
}