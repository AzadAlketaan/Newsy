import { Navigate, useRoutes } from 'react-router-dom';
import { RequireAuth } from 'react-auth-kit';
// layouts
import DashboardLayout from './layouts/dashboard';
import SimpleLayout from './layouts/simple';
//
import ArticlePage from './pages/ArticlePage';
import UserProfile from './pages/UserProfile';
import LoginPage from './pages/LoginPage';
import SignUpPage from './pages/SignUpPage';
import Page404 from './pages/Page404';
import NewsfeedsPage from './pages/NewsfeedsPage';

// ----------------------------------------------------------------------

export default function Router() {
  const routes = useRoutes([
    {
      path: '/dashboard',
      element: <DashboardLayout />,
      children: [
        { element: <Navigate to="/dashboard/app" />, index: true },
        { path: 'app', element: <NewsfeedsPage /> },
        { path: 'newsfeeds', element: <NewsfeedsPage /> },
        { path: 'articles', element: <ArticlePage /> },
        { path: 'profile', element: 
            <RequireAuth loginPath={'/login'}>
              <UserProfile />
            </RequireAuth>
        },
      ],
    },
    {
      path: 'login',
      element: <LoginPage />,
    },
    {
      path: 'signup',
      element: <SignUpPage />,
    },
    {
      element: <SimpleLayout />,
      children: [
        { element: <Navigate to="/dashboard/app" />, index: true },
        { path: '404', element: <Page404 /> },
        { path: '*', element: <Navigate to="/404" /> },
      ],
    },
    {
      path: '*',
      element: <Navigate to="/404" replace />,
    },
  ]);

  return routes;
}
