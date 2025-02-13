public function index($identifier) {
    return view('profile', compact('identifier'));
}

public function courses($identifier) {
    return view('courses', compact('identifier'));
}

public function exams($identifier) {
    return view('exams', compact('identifier'));
}
