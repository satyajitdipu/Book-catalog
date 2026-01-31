import { render, screen } from '@testing-library/react';
import App from './App';

test('renders app without crashing', () => {
  render(<App />);
  // Since App renders routes, just check it renders
  expect(document.querySelector('.App')).toBeInTheDocument();
});
