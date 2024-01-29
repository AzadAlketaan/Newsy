import React, { useState, useEffect } from "react";
import { useAuthUser, useAuthHeader } from 'react-auth-kit';
import { useTheme } from '@mui/material/styles';
import {
  Avatar,
  AlertTitle,
  Alert,
  Typography,
  Button,
  Card,
  CardActions,
  CardContent,
  CardHeader,
  Divider,
  Box,
  OutlinedInput,
  InputLabel,
  MenuItem,
  FormControl,
  Select,
  Chip
} from '@mui/material';
import axios from "../axios-instance";

const ITEM_HEIGHT = 48;
  const ITEM_PADDING_TOP = 8;
  const MenuProps = {
    PaperProps: {
      style: {
        maxHeight: ITEM_HEIGHT * 4.5 + ITEM_PADDING_TOP,
        width: 250,
      },
    },
  };

  function getStyles(item, itemName, theme) {
    return {
      fontWeight:
        itemName.indexOf(item.name) === -1
          ? theme.typography.fontWeightRegular
          : theme.typography.fontWeightMedium,
    };
  }

function UserProfile() {
  const auth = useAuthUser();
  const authHeader = useAuthHeader();
  const [error, setError] = useState(null);
  const theme = useTheme();
  const [CATEGORIES, setCategories] = useState([]);
  const [SOURCES, setSources] = useState([]);
  const [AUTHORS, setAuthors] = useState([]);
  const [categoryName, setCategoryName] = useState([]);
  const [sourceName, setSourceName] = useState([]);
  const [authorName, setAuthorName] = useState([]);
  const [alert, setAlert] = useState(false);

  const handleCategoryChange = (event) => {
    const {
      target: { value },
    } = event;
    setCategoryName(
      // On autofill we get a stringified value.
      typeof value === 'string' ? value.split(',') : value,
    );
  };

  const handleSourceChange = (event) => {
    const {
      target: { value },
    } = event;
    setSourceName(
      // On autofill we get a stringified value.
      typeof value === 'string' ? value.split(',') : value,
    );
  };

  const handleAuthorChange = (event) => {
    const {
      target: { value },
    } = event;
    setAuthorName(
      // On autofill we get a stringified value.
      typeof value === 'string' ? value.split(',') : value,
    );
  };

  const fetchCategories = async () => {
    const { data } = await axios.get("/utils/categories/");
    setCategories(data.data);
  };
  
  const fetchSources = async () => {
    const { data } = await axios.get("/utils/sources/");
    setSources(data.data);
  };

  const fetchAuthors = async () => {
    const { data } = await axios.get("/utils/authors/");
    setAuthors(data.data);
  };

  const fetchUserCustomizations = async () => {
    const { data } = await axios.get("/users/favorites/");
    if(data.data[0].categories !== null) setCategoryName(data.data[0].categories);
    if(data.data[0].sources !== null) setSourceName(data.data[0].sources);
    if(data.data[0].authors !== null) setAuthorName(data.data[0].authors);
  };
  
  useEffect((event) => {
    fetchCategories();
    fetchSources();
    fetchAuthors();
    fetchUserCustomizations();
  }, []);

  const handleSave = () => {
    axios.post('/users/favorites/store',
      {
        categoryName,
        sourceName,
        authorName
      },
      { headers: {"Authorization" : authHeader()} })
      .then(() => {
        setAlert(true);
      })
      .catch((error) => {
        alert(false);
      });
  };

  return (
    <>
      {alert
        ? <Alert severity='success'>
            <AlertTitle>Success</AlertTitle>
            Your news feed has been <strong>Successfully</strong> customized
          </Alert>
        : <></>
      }
      <Card>
        <CardHeader
          avatar={
            <Avatar aria-label="user">
              {auth()?.username?.charAt(0)}
            </Avatar>
          }
          title={auth()?.username}
          subheader={auth()?.email}
        />
        <Divider />
        <CardContent>            
          <Typography variant="h4" gutterBottom>
          Customize your news feed:
          </Typography>
          <FormControl sx={{ m: 1, width: 300 }}>
            <InputLabel id="demo-multiple-chip-label">Categories</InputLabel>
            <Select
              labelId="demo-multiple-chip-label"
              id="demo-multiple-chip"
              multiple
              value={categoryName}
              onChange={handleCategoryChange}
              input={<OutlinedInput id="select-multiple-chip" label="Chip" />}
              renderValue={(selected) => (
                <Box sx={{ display: 'flex', flexWrap: 'wrap', gap: 0.5 }}>
                  {selected.map((value) => (
                    <Chip key={value} label={value} />
                  ))}
                </Box>
              )}
              MenuProps={MenuProps}
            >
              {CATEGORIES.map((item) => (
                <MenuItem
                  key={item.id}
                  value={item.name}
                  style={getStyles(item, categoryName, theme)}
                >
                  {item.name}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
          <FormControl sx={{ m: 1, width: 300 }}>
            <InputLabel id="demo-multiple-chip-label">Sources</InputLabel>
            <Select
              labelId="demo-multiple-chip-label"
              id="demo-multiple-chip"
              multiple
              value={sourceName}
              onChange={handleSourceChange}
              input={<OutlinedInput id="select-multiple-chip" label="Chip" />}
              renderValue={(selected) => (
                <Box sx={{ display: 'flex', flexWrap: 'wrap', gap: 0.5 }}>
                  {selected.map((value) => (
                    <Chip key={value} label={value} />
                  ))}
                </Box>
              )}
              MenuProps={MenuProps}
            >
              {SOURCES.map((item) => (
                <MenuItem
                  key={item.id}
                  value={item.name}
                  style={getStyles(item, sourceName, theme)}
                >
                  {item.name}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
          <FormControl sx={{ m: 1, width: 300 }}>
            <InputLabel id="demo-multiple-chip-label">Authors</InputLabel>
            <Select
              labelId="demo-multiple-chip-label"
              id="demo-multiple-chip"
              multiple
              value={authorName}
              onChange={handleAuthorChange}
              input={<OutlinedInput id="select-multiple-chip" label="Chip" />}
              renderValue={(selected) => (
                <Box sx={{ display: 'flex', flexWrap: 'wrap', gap: 0.5 }}>
                  {selected.map((value) => (
                    <Chip key={value} label={value} />
                  ))}
                </Box>
              )}
              MenuProps={MenuProps}
            >
              {AUTHORS.map((item) => (
                <MenuItem
                  key={item.id}
                  value={item.name}
                  style={getStyles(item, authorName, theme)}
                >
                  {item.name}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </CardContent>
        
        <CardActions>
          <Button variant="contained" color="primary" onClick={handleSave}>
            Save
          </Button>
        </CardActions>
      </Card>
    </>
  );

}


export default UserProfile;