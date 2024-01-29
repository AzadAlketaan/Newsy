import { useState } from 'react';
import { Link } from 'react-router-dom';
// @mui
import { alpha } from '@mui/material/styles';
import { Box, Divider, Typography, Stack, MenuItem, Avatar, IconButton, Popover } from '@mui/material';
import { useSignOut, useAuthUser, useAuthHeader} from 'react-auth-kit';

import axios from "../../../axios-instance";
// ----------------------------------------------------------------------

export default function AccountPopover() {

  const [open, setOpen] = useState(null);
  const auth = useAuthUser();
  const signOut = useSignOut();
  const authHeader = useAuthHeader();
  const handleOpen = (event) => {
    setOpen(event.currentTarget);
  };

  const handleClose = () => {
    setOpen(null);
  };

  const handleClick = ()  => {

    axios.post("/auth/logout", {}, { headers: {"Authorization" : authHeader()} })
    .then((res) =>
    {
      signOut();
    });   
  };

  return (
    <>
      <IconButton
        onClick={handleOpen}
        sx={{
          p: 0,
          ...(open && {
            '&:before': {
              zIndex: 1,
              content: "''",
              width: '100%',
              height: '100%',
              borderRadius: '50%',
              position: 'absolute',
              bgcolor: (theme) => alpha(theme.palette.grey[900], 0.8),
            },
          }),
        }}
      >
        <Avatar src={auth().user_image} alt="photoURL"/>
      </IconButton>

      <Popover
        open={Boolean(open)}
        anchorEl={open}
        onClose={handleClose}
        anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
        transformOrigin={{ vertical: 'top', horizontal: 'right' }}
        PaperProps={{
          sx: {
            p: 0,
            mt: 1.5,
            ml: 0.75,
            width: 180,
            '& .MuiMenuItem-root': {
              typography: 'body2',
              borderRadius: 0.75,
            },
          },
        }}
      >
        <Box sx={{ my: 1.5, px: 2.5 }}>
          <Typography variant="subtitle2" noWrap>
            {auth().username}
          </Typography>
          <Typography variant="body2" sx={{ color: 'text.secondary' }} noWrap>
            {auth().email}
          </Typography>
        </Box>

        <Divider sx={{ borderStyle: 'dashed' }} />

        <Stack sx={{ p: 1 }}>
          <MenuItem component={Link} to="/dashboard/newsfeeds" sx={{ m: 1 }} onClick={handleClose}>Home</MenuItem>
          <MenuItem component={Link} to="/dashboard/profile" sx={{ m: 1 }} onClick={handleClose}>Profile</MenuItem>
        </Stack>

        <Divider sx={{ borderStyle: 'dashed' }} />

        <MenuItem  onClick={handleClick} sx={{ m: 1 }}>
          Logout
        </MenuItem>
      </Popover>
    </>
  );
}
