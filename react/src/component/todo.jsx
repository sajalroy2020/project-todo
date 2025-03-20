import React, { useState, useEffect } from 'react';

const Todo = () => {
    const [todos, setTodos] = useState(() => {
        const savedTodos = localStorage.getItem('todos');
        return savedTodos ? JSON.parse(savedTodos) : [];
    });
    const [input, setInput] = useState('');
    const [isEditing, setIsEditing] = useState(false);
    const [currentIndex, setCurrentIndex] = useState(null);
    const [filter, setFilter] = useState('all');

    useEffect(() => {
        localStorage.setItem('todos', JSON.stringify(todos));
    }, [todos]);

    const addTodo = () => {
        if (input.trim()) {
            if (isEditing) {
                const updatedTodos = todos.map((todo, index) =>
                    index === currentIndex ? { ...todo, text: input } : todo
                );
                setTodos(updatedTodos);
                setIsEditing(false);
                setCurrentIndex(null);
            } else {
                setTodos([...todos, { text: input, completed: false }]);
            }
            setInput('');
        }
    };

    const deleteTodo = (index) => {
        setTodos(todos.filter((_, i) => i !== index));
    };

    const editTodo = (index) => {
        setInput(todos[index].text);
        setIsEditing(true);
        setCurrentIndex(index);
    };

    const toggleComplete = (index) => {
        const updatedTodos = todos.map((todo, i) =>
            i === index ? { ...todo, completed: !todo.completed } : todo
        );
        setTodos(updatedTodos);
    };

    const filteredTodos = todos.filter(todo => {
        if (filter === 'completed') return todo.completed;
        if (filter === 'active') return !todo.completed;
        return true;
    });

    return (
        <div>
            <h1>Todo List</h1>
            <div>
                <input
                    type="text"
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    placeholder="Add a new task"
                />
                <button onClick={addTodo}>
                    {isEditing ? 'Update' : 'Add'}
                </button>
            </div>
            <div style={{paddingTop: '10px'}}>
                <button onClick={() => setFilter('all')}>All</button>
                <button style={{marginLeft: '4px', marginRight: '4px'}} onClick={() => setFilter('completed')}>Completed</button>
                <button onClick={() => setFilter('active')}>Active</button>
            </div>
            <ul>
                {filteredTodos.map((todo, index) => (
                    <li key={index}
                        style={{
                            display: 'flex',
                            justifyContent: 'space-between',
                            alignItems: 'center',
                            marginBottom: '5px',
                            padding: '5px',
                            border: '1px solid #ccc',
                            borderRadius: '4px',
                            width: '300px',
                            textDecoration: todo.completed ? 'line-through' : 'none',
                            color: todo.completed ? '#fff' : '#000',
                            background: todo.completed ? '#03a90d' : '#888'
                        }}
                    >
                        <input
                            type="checkbox"
                            checked={todo.completed}
                            onChange={() => toggleComplete(index)}
                        />
                        {todo.text}
                        <div>
                            <button onClick={() => editTodo(index)}>Edit</button>
                            <button onClick={() => deleteTodo(index)}>Delete</button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default Todo;